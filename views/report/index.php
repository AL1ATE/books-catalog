<?php

use yii\helpers\Html;

/** @var array $authors */
/** @var int $year */

$this->title = 'Отчёт по авторам';
?>

<div class="page-head">
    <div>
        <div class="page-label">Аналитика</div>
        <h1>Топ-10 авторов за год</h1>
    </div>
</div>

<div class="content-card">

    <form method="get" class="mb-4">
        <input type="hidden" name="r" value="report/index">

        <div style="display:flex; gap:12px; align-items:end;">
            <div>
                <label class="form-label">Год издания</label>

                <input
                    type="number"
                    name="year"
                    value="<?= Html::encode($year) ?>"
                    class="form-control"
                >
            </div>

            <div>
                <button class="btn btn-primary">
                    Показать отчёт
                </button>
            </div>
        </div>
    </form>

    <table class="table app-table">
        <thead>
        <tr>
            <th>#</th>
            <th>Автор</th>
            <th>Количество книг</th>
        </tr>
        </thead>

        <tbody>
        <?php if (!$authors): ?>
            <tr>
                <td colspan="3">Нет данных за выбранный год</td>
            </tr>
        <?php else: ?>
            <?php foreach ($authors as $index => $author): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= Html::encode($author['full_name']) ?></td>
                    <td><?= (int)$author['books_count'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

</div>