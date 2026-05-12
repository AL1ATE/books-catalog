<?php

/** @var app\models\Author $model */

$this->title = 'Update Author';
?>

<h1>Update Author</h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>