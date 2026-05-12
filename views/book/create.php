<?php

$this->title = 'Добавить книгу';
?>

<h1>Добавить книгу</h1>

<?= $this->render('_form', [
    'model' => $model,
    'authors' => $authors,
]) ?>