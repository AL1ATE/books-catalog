<?php

namespace app\controllers;

use app\models\Author;
use app\models\Book;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class BookController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Book::find()->with('authors')->orderBy(['id' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView(int $id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Book();
        $model->authorIds = [];

        if ($model->load(Yii::$app->request->post())) {
            $model->authorIds = Yii::$app->request->post('Book')['authorIds'] ?? [];

            $coverFile = UploadedFile::getInstance($model, 'coverImageFile');

            if ($this->saveBook($model, $coverFile)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->renderForm($model, 'create');
    }

    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        $model->authorIds = ArrayHelper::getColumn($model->authors, 'id');

        if ($model->load(Yii::$app->request->post())) {
            $model->authorIds = Yii::$app->request->post('Book')['authorIds'] ?? [];

            $coverFile = UploadedFile::getInstance($model, 'coverImageFile');

            if ($this->saveBook($model, $coverFile)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->renderForm($model, 'update');
    }

    public function actionDelete(int $id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    private function renderForm(Book $model, string $view)
    {
        return $this->render($view, [
            'model' => $model,
            'authors' => Author::find()->orderBy(['full_name' => SORT_ASC])->all(),
        ]);
    }

    private function saveBook(Book $model, ?UploadedFile $coverFile): bool
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
                $model->addError('coverImageFile', 'Cannot upload cover image');
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
                ->delete('{{%book_author}}', ['book_id' => $model->id])
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
            return true;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    private function findModel(int $id): Book
    {
        $model = Book::find()->with('authors')->where(['id' => $id])->one();

        if (!$model) {
            throw new NotFoundHttpException('Book not found');
        }

        return $model;
    }
}