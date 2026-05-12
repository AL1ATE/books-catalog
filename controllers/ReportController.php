<?php

namespace app\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;

class ReportController extends Controller
{
    public function actionIndex()
    {
        $year = (int)Yii::$app->request->get('year', date('Y'));

        $authors = (new Query())
            ->select([
                'author.id',
                'author.full_name',
                'books_count' => 'COUNT(book.id)',
            ])
            ->from('author')
            ->innerJoin('book_author', 'book_author.author_id = author.id')
            ->innerJoin('book', 'book.id = book_author.book_id')
            ->where(['book.publication_year' => $year])
            ->groupBy([
                'author.id',
                'author.full_name',
            ])
            ->orderBy([
                'books_count' => SORT_DESC,
            ])
            ->limit(10)
            ->all();

        return $this->render('index', [
            'authors' => $authors,
            'year' => $year,
        ]);
    }
}