<?php

namespace app\controllers;

use app\models\Author;
use app\models\Book;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use app\services\BookService;

class BookController extends Controller
{
    private BookService $bookService;

    public function __construct($id, $module, $config = [])
    {
        $this->bookService = new BookService();

        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Book::find()->with('authors')->orderBy(['id' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView(int $id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Book();
        $model->authorIds = [];

        if ($model->load(Yii::$app->request->post())) {
            $model->authorIds = Yii::$app->request->post('Book')['authorIds'] ?? [];

            $coverFile = UploadedFile::getInstance($model, 'coverImageFile');

            if ($this->bookService->save($model, $coverFile)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->renderForm($model, 'create');
    }

    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        $model->authorIds = ArrayHelper::getColumn($model->authors, 'id');

        if ($model->load(Yii::$app->request->post())) {
            $model->authorIds = Yii::$app->request->post('Book')['authorIds'] ?? [];

            $coverFile = UploadedFile::getInstance($model, 'coverImageFile');

            if ($this->bookService->save($model, $coverFile)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->renderForm($model, 'update');
    }

    public function actionDelete(int $id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    private function renderForm(Book $model, string $view)
    {
        return $this->render($view, [
            'model' => $model,
            'authors' => Author::find()->orderBy(['full_name' => SORT_ASC])->all(),
        ]);
    }

    private function findModel(int $id): Book
    {
        $model = Book::find()->with('authors')->where(['id' => $id])->one();

        if (!$model) {
            throw new NotFoundHttpException('Book not found');
        }

        return $model;
    }
}