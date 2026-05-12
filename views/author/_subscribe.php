<?php

use app\models\Author;
use app\models\AuthorSubscription;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var Author $author */

$model = new AuthorSubscription();
$model->author_id = $author->id;
?>

<div class="grid-view mt-4">

    <h3>Subscribe to new books</h3>

    <?php $form = ActiveForm::begin([
        'action' => ['/subscription/create', 'authorId' => $author->id],
    ]); ?>

    <?= $form->field($model, 'phone')
        ->textInput([
            'placeholder' => '+79991234567',
        ]) ?>

    <div class="form-group">
        <?= Html::submitButton(
            'Subscribe',
            ['class' => 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>