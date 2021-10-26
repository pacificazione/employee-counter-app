<?php

use yii\db\Migration;

/**
 * Миграция Сотрудник2Отдел.
 */
class m211019_141143_create_employee2department_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employee2department}}', [
            'employee_id' => $this->integer(),
            'department_id' => $this->integer(),
            'PRIMARY KEY(employee_id, department_id)',
        ]);

        $this->addCommentOnTable('{{%employee2department}}', 'Сотрудник2Отдел');

        $this->createIndex(
            'IX_employee_id',
            '{{%employee2department}}',
            'employee_id',
        );

        $this->addForeignKey(
            'FK_employee_id',
            '{{%employee2department}}', 'employee_id',
            '{{%employee}}', 'id',
            'cascade',
        );

        $this->createIndex(
            'IX_department_id',
            '{{%employee2department}}',
            'department_id',
        );

        $this->addForeignKey(
            'FK_department_id',
            '{{%employee2department}}', 'department_id',
            '{{%department}}', 'id',
            'cascade',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_employee_id', '{{%employee2department}}');
        $this->dropIndex('IX_employee_id', '{{%employee2department}}');
        $this->dropForeignKey('FK_department_id', '{{%employee2department}}');
        $this->dropIndex('IX_department_id', '{{%employee2department}}');
        $this->dropTable('{{%employee2department}}');
    }
}
