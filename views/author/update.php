<?php

/** @var app\models\Author $model */

$this->title = 'Редактировать автора';
?>

<h1>Редактировать автора</h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>