<?php

$this->title = 'Редактировать книгу';
?>

<h1>Редактировать книгу</h1>

<?= $this->render('_form', [
    'model' => $model,
    'authors' => $authors,
]) ?>