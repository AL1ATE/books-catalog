<?php

use yii\db\Migration;

class m260512_132353_create_book_catalog_tables extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(100)->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'publication_year' => $this->integer()->notNull(),
            'description' => $this->text()->null(),
            'isbn' => $this->string(32)->notNull()->unique(),
            'cover_image' => $this->string(255)->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string(255)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('{{%book_author}}', [
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey(
            'pk_book_author',
            '{{%book_author}}',
            ['book_id', 'author_id']
        );

        $this->addForeignKey(
            'fk_book_author_book',
            '{{%book_author}}',
            'book_id',
            '{{%book}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_book_author_author',
            '{{%book_author}}',
            'author_id',
            '{{%author}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%author_subscription}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'phone' => $this->string(32)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_author_subscription_author',
            '{{%author_subscription}}',
            'author_id',
            '{{%author}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx_author_subscription_author_phone',
            '{{%author_subscription}}',
            ['author_id', 'phone'],
            true
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%author_subscription}}');
        $this->dropTable('{{%book_author}}');
        $this->dropTable('{{%author}}');
        $this->dropTable('{{%book}}');
        $this->dropTable('{{%user}}');
    }
}