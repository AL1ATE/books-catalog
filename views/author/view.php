<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var app\models\Author $model */

$this->title = $model->full_name;
?>

<h1><?= Html::encode($model->full_name) ?></h1>

<p>
    <?= Html::a('Назад', ['index'], ['class' => 'btn btn-outline-light']) ?>

    <?php if (!Yii::$app->user->isGuest): ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить этого автора?',
                'method' => 'post',
            ],
        ]) ?>
    <?php endif; ?>
</p>

<?= DetailView::widget([
    'model' => $model,
    'options' => ['class' => 'table detail-view'],
    'attributes' => [
        'id',
        'full_name',
        'created_at:datetime',
        'updated_at:datetime',
    ],
]) ?>

<?php if (Yii::$app->user->isGuest): ?>
    <?= $this->render('_subscribe', [
        'author' => $model,
    ]) ?>
<?php endif; ?>