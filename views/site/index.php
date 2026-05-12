<?php

use yii\helpers\Html;

$this->title = 'Books Catalog';
?>

<section class="hero">
    <div class="hero-content">

        <h1>Books Catalog</h1>

        <p>
            Небольшой каталог книг с авторами, подписками,
            отчетом по авторам и SMS-уведомлениями.
        </p>

        <div class="hero-actions">
            <?= Html::a('Открыть книги', ['/book/index'], ['class' => 'btn btn-primary btn-lg']) ?>
            <?= Html::a('Авторы', ['/author/index'], ['class' => 'btn btn-outline-light btn-lg']) ?>
        </div>
    </div>
</section>