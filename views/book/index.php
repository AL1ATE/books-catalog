<?php

use app\models\Book;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Книги';
?>

<div class="page-head">
    <div>
        <div class="page-label">Каталог</div>
        <h1>Книги</h1>
    </div>

    <?php if (!Yii::$app->user->isGuest): ?>
        <?= Html::a('+ Добавить книгу', ['create'], ['class' => 'btn btn-success']) ?>
    <?php endif; ?>
</div>

<div class="content-card">

<?= GridView::widget([
    'dataProvider' => $dataProvider,

    'summary' => 'Показано <b>{begin}-{end}</b> из <b>{totalCount}</b>',

    'emptyText' => 'Книг пока нет',

    'tableOptions' => [
        'class' => 'table app-table',
    ],

    'columns' => [

        [
            'attribute' => 'title',
            'label' => 'Название',
            'format' => 'raw',
            'value' => static function (Book $book) {
                return Html::a(
                    Html::encode($book->title),
                    ['view', 'id' => $book->id],
                    ['class' => 'table-title']
                );
            },
        ],

        [
            'attribute' => 'publication_year',
            'label' => 'Год',
            'contentOptions' => [
                'style' => 'width:120px;',
            ],
        ],

        [
            'label' => 'Авторы',
            'format' => 'raw',
            'value' => static function (Book $book) {

                if (!$book->authors) {
                    return '<span class="text-muted">—</span>';
                }

                return implode(' ', array_map(
                    static fn($author) =>
                        '<span class="badge-soft">'
                        . Html::encode($author->full_name)
                        . '</span>',
                    $book->authors
                ));
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