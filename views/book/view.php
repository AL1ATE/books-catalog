<?php

use app\models\Author;
use app\models\Book;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var Book $model */

$this->title = $model->title;
?>

<h1><?= Html::encode($model->title) ?></h1>

<p>
    <?= Html::a('Назад', ['index'], ['class' => 'btn btn-outline-light']) ?>

    <?php if (!Yii::$app->user->isGuest): ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить эту книгу?',
                'method' => 'post',
            ],
        ]) ?>
    <?php endif; ?>
</p>

<?php if ($model->cover_image): ?>
    <p>
        <img
            src="<?= $model->cover_image ?>"
            alt="<?= Html::encode($model->title) ?>"
            style="max-width: 240px; border-radius: 16px;"
        >
    </p>
<?php endif; ?>

<?= DetailView::widget([
    'model' => $model,
    'options' => ['class' => 'table detail-view'],
    'attributes' => [
        'id',
        'title',
        'publication_year',
        'isbn',
        'description:ntext',
        [
            'label' => 'Авторы',
            'format' => 'raw',
            'value' => static function (Book $book) {
                return implode('<br>', array_map(
                    static fn(Author $author) => Html::encode($author->full_name),
                    $book->authors
                ));
            },
        ],
        'created_at:datetime',
        'updated_at:datetime',
    ],
]) ?>