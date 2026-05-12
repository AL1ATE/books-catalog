<?php

use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Авторы';
?>

<div class="page-head">
    <div>
        <div class="page-label">Справочник</div>
        <h1>Авторы</h1>
    </div>

    <?php if (!Yii::$app->user->isGuest): ?>
        <?= Html::a('+ Добавить автора', ['create'], ['class' => 'btn btn-success']) ?>
    <?php endif; ?>
</div>

<div class="content-card">

<?= GridView::widget([
    'dataProvider' => $dataProvider,

    'summary' => 'Показано <b>{begin}-{end}</b> из <b>{totalCount}</b>',

    'emptyText' => 'Авторов пока нет',

    'tableOptions' => [
        'class' => 'table app-table',
    ],

    'columns' => [

        [
            'attribute' => 'full_name',

            'label' => 'ФИО автора',

            'format' => 'raw',

            'value' => static function ($author) {
                return Html::a(
                    Html::encode($author->full_name),
                    ['view', 'id' => $author->id],
                    ['class' => 'table-title']
                );
            },
        ],

        [
            'class' => yii\grid\ActionColumn::class,

            'header' => 'Действия',

            'template' => Yii::$app->user->isGuest
                ? '{view}'
                : '{view} {update} {delete}',

            'contentOptions' => [
                'class' => 'actions-cell',
                'style' => 'width:140px;',
            ],
        ],
    ],
]) ?>

</div>