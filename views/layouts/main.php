<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

/** @var string $content */

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

\app\assets\AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title ?: 'Books Catalog') ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column min-vh-100">
<?php $this->beginBody() ?>

<header class="app-header">
    <div class="container">
        <?php
        NavBar::begin([
            'brandLabel' => 'Books Catalog',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar navbar-expand-lg navbar-dark'],
        ]);

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ms-auto align-items-lg-center'],
            'items' => [
                ['label' => 'Книги', 'url' => ['/book/index']],
                ['label' => 'Авторы', 'url' => ['/author/index']],
                ['label' => 'Отчёт', 'url' => ['/report/index']],
                Yii::$app->user->isGuest
                    ? ['label' => 'Войти', 'url' => ['/auth/login']]
                    : '<li class="nav-item">'
                        . Html::beginForm(['/auth/logout'], 'post', ['class' => 'd-inline'])
                        . Html::submitButton(
                            'Выйти (' . Html::encode(Yii::$app->user->identity->username) . ')',
                            ['class' => 'btn btn-outline-light btn-sm ms-lg-3']
                        )
                        . Html::endForm()
                        . '</li>',
            ],
        ]);

        NavBar::end();
        ?>
    </div>
</header>

<main class="flex-grow-1">
    <div class="container py-4">
        <?= $content ?>
    </div>
</main>

<footer class="app-footer">
    <div class="container">
        <span>Books Catalog</span>
        <span><?= date('Y') ?></span>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>