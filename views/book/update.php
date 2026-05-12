<?php

$this->title = 'Update Book';
?>

<h1>Update Book</h1>

<?= $this->render('_form', [
    'model' => $model,
    'authors' => $authors,
]) ?>