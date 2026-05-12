<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \app\models\LoginForm $model */

$this->title = 'Login';
?>

<h1>Вход в аккаунт</h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'username') ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<div class="form-group">
    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>