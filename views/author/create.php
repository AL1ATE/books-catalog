<?php

/** @var app\models\Author $model */

$this->title = 'Добавить автора';
?>

<h1>Добавить автора</h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>