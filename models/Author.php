<?php

namespace app\models;

use yii\db\ActiveRecord;

class Author extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%author}}';
    }

    public function rules(): array
    {
        return [
            [['full_name'], 'required'],
            [['full_name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'full_name' => 'ФИО автора',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлён',
        ];
    }

    public function getBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable('{{%book_author}}', ['author_id' => 'id']);
    }

    public function getSubscriptions()
    {
        return $this->hasMany(AuthorSubscription::class, ['author_id' => 'id']);
    }
}