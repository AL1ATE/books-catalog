<?php

use app\models\Book;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books';
?>

<h1>Books</h1>

<?php if (!Yii::$app->user->isGuest): ?>
    <p>
        <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php endif; ?>

<div class="grid-view">

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => ['class' => 'table'],
    'columns' => [
        'id',
        'title',
        'publication_year',
        'isbn',
        [
            'label' => 'Authors',
            'format' => 'raw',
            'value' => static function (Book $book) {
                return implode(', ', array_map(
                    static fn($author) => $author->full_name,
                    $book->authors
                ));
            },
        ],
        [
            'class' => yii\grid\ActionColumn::class,
            'template' => Yii::$app->user->isGuest
                ? '{view}'
                : '{view} {update} {delete}',
        ],
    ],
]) ?>

</div>