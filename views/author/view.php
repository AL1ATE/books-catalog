<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var app\models\Author $model */

$this->title = $model->full_name;
?>

<h1><?= Html::encode($model->full_name) ?></h1>

<p>
    <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>

    <?php if (!Yii::$app->user->isGuest): ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Delete this author?',
                'method' => 'post',
            ],
        ]) ?>
    <?php endif; ?>
</p>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'full_name',
        'created_at:datetime',
        'updated_at:datetime',
    ],
]) ?>