<?php

/** @var app\models\Author $model */

$this->title = 'Create Author';
?>

<h1>Create Author</h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>