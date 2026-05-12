<?php

use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Authors';
?>

<h1>Authors</h1>

<?php if (!Yii::$app->user->isGuest): ?>
    <p><?= Html::a('Create Author', ['create'], ['class' => 'btn btn-success']) ?></p>
<?php endif; ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'full_name',
        [
            'class' => yii\grid\ActionColumn::class,
            'template' => Yii::$app->user->isGuest ? '{view}' : '{view} {update} {delete}',
        ],
    ],
]) ?>