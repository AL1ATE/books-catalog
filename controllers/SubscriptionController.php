<?php

namespace app\controllers;

use app\models\Author;
use app\models\AuthorSubscription;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SubscriptionController extends Controller
{
    public function actionCreate(int $authorId)
    {
        $author = Author::findOne($authorId);

        if (!$author) {
            throw new NotFoundHttpException('Author not found');
        }

        $model = new AuthorSubscription();
        $model->author_id = $author->id;
        $model->created_at = time();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash(
                'success',
                'You have successfully subscribed'
            );

            return $this->redirect(['/author/view', 'id' => $author->id]);
        }

        Yii::$app->session->setFlash(
            'error',
            'Subscription failed'
        );

        return $this->redirect(['/author/view', 'id' => $author->id]);
    }
}