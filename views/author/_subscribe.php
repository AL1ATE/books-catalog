<?php

use app\models\Author;
use app\models\AuthorSubscription;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var Author $author */

$model = new AuthorSubscription();
$model->author_id = $author->id;
?>

<div class="content-card mt-4">

    <div class="page-label">Подписка</div>

    <h3>Уведомления о новых книгах автора</h3>

    <p class="text-muted">
        Оставьте телефон, и при добавлении новой книги этого автора будет отправлено SMS.
    </p>

    <?php $form = ActiveForm::begin([
        'action' => ['/subscription/create', 'authorId' => $author->id],
    ]); ?>

    <?= $form->field($model, 'phone')->textInput([
        'placeholder' => '+79991234567',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Подписаться', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>