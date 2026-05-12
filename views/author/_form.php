<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\models\Author $model */

$form = ActiveForm::begin();
?>

<?= $form->field($model, 'full_name') ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>