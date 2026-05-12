<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\models\Author $model */

$form = ActiveForm::begin();
?>

<div class="content-card">

    <?= $form->field($model, 'full_name') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

</div>

<?php ActiveForm::end(); ?>