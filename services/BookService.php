<?php

namespace app\services;

use app\models\AuthorSubscription;
use app\models\Book;
use Yii;
use yii\web\UploadedFile;

class BookService
{
    public function __construct(
        private readonly SmsService $smsService = new SmsService(),
    ) {
    }

    public function save(Book $model, ?UploadedFile $coverFile): bool
    {
        $isNew = $model->isNewRecord;
        $now = time();

        if ($isNew) {
            $model->created_at = $now;
        }

        $model->updated_at = $now;

        if ($coverFile) {
            $fileName = uniqid('book_', true) . '.' . $coverFile->extension;

            $path = Yii::getAlias('@webroot/uploads/books/') . $fileName;

            if (!$coverFile->saveAs($path)) {
                $model->addError(
                    'coverImageFile',
                    'Cannot upload cover image'
                );

                return false;
            }

            $model->cover_image = '/uploads/books/' . $fileName;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (!$model->save()) {
                $transaction->rollBack();
                return false;
            }

            Yii::$app->db->createCommand()
                ->delete('{{%book_author}}', [
                    'book_id' => $model->id,
                ])
                ->execute();

            foreach ($model->authorIds as $authorId) {
                Yii::$app->db->createCommand()
                    ->insert('{{%book_author}}', [
                        'book_id' => $model->id,
                        'author_id' => (int)$authorId,
                    ])
                    ->execute();
            }

            $transaction->commit();

            if ($isNew) {
                $this->notifySubscribers($model);
            }

            return true;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    private function notifySubscribers(Book $book): void
    {
        $subscriptions = AuthorSubscription::find()
            ->where(['author_id' => $book->authorIds])
            ->all();

        foreach ($subscriptions as $subscription) {
            $this->smsService->send(
                $subscription->phone,
                'Новая книга: ' . $book->title
            );
        }
    }
}