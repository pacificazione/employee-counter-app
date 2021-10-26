<?php

use yii\db\Migration;

/**
 * Миграция отдела.
 */
class m211019_140421_create_department_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%department}}', [
            'id' => $this->primaryKey(),
            'departmentName' => $this->string()->notNull()->comment('Название отдела'),
            'created_at' => $this->integer()->notNull()->comment('Создан'),
            'updated_at' => $this->integer()->notNull()->comment('Обновлен')
        ]);

        $this->addCommentOnTable('{{%department}}', 'Отдел');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%department}}');
    }
}
