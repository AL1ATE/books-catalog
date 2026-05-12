<?php

use app\models\Author;
use app\models\Book;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var Book $model */
/** @var Author[] $authors */

$form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
]);

$authorsList = ArrayHelper::map($authors, 'id', 'full_name');
?>

<div class="content-card">

    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'publication_year')->input('number') ?>

    <?= $form->field($model, 'isbn')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'authorIds')->checkboxList($authorsList) ?>

    <?= $form->field($model, 'coverImageFile')->fileInput() ?>

    <?php if ($model->cover_image): ?>
        <p>
            <img
                src="<?= $model->cover_image ?>"
                alt=""
                style="max-width: 180px; border-radius: 14px;"
            >
        </p>
    <?php endif; ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

</div>

<?php ActiveForm::end(); ?>