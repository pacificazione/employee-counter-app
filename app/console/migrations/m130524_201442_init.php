<?php

use yii\db\Migration;

/**
 * Миграция сотрудника.
 */
class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%employee}}', [
            'id' => $this->primaryKey(),
            'firstName' => $this->string()->notNull()->comment('Имя'),
            'lastName' => $this->string()->notNull()->comment('Фамилия'),
            'education' => $this->string()->comment('Образование'),
            'post' => $this->string()->notNull()->comment('Должность'),
            'age'=> $this->integer()->notNull()->comment('Возраст'),
            'nationality' => $this->string()->notNull()->comment('Гражданство'),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'verification_token' => $this->string()->defaultValue(null),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(9),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addCommentOnTable('{{%employee}}', 'Сотрудник');
    }


    public function down()
    {
        $this->dropTable('{{%employee}}');
    }
}
