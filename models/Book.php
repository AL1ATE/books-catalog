<?php

namespace app\models;

use yii\db\ActiveRecord;

class Book extends ActiveRecord
{
    public array $authorIds = [];

    public $coverImageFile;

    public static function tableName(): string
    {
        return '{{%book}}';
    }

    public function rules(): array
    {
        return [
            [['title', 'publication_year', 'isbn'], 'required'],
            [['publication_year'], 'integer'],
            [['description'], 'string'],
            [['title', 'cover_image'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 32],
            [['isbn'], 'unique'],
            [['authorIds'], 'each', 'rule' => ['integer']],
            [['coverImageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'jpeg', 'webp']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'title' => 'Название',
            'publication_year' => 'Год издания',
            'description' => 'Описание',
            'isbn' => 'ISBN',
            'coverImageFile' => 'Обложка',
            'authorIds' => 'Авторы',
        ];
    }

    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('{{%book_author}}', ['book_id' => 'id']);
    }
}