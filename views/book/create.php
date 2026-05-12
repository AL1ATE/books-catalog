<?php

$this->title = 'Create Book';
?>

<h1>Create Book</h1>

<?= $this->render('_form', [
    'model' => $model,
    'authors' => $authors,
]) ?>