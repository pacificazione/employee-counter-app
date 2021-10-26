<?php

namespace common\models;

use common\models\query\DepartmentQuery;
use common\models\query\Employee2DepartmentQuery;
use common\models\query\EmployeeQuery;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Модель сотрудник2отдел.
 *
 * @property int $employee_id
 * @property int $department_id
 *
 * @property Department $department
 * @property Employee $employee
 */
class Employee2Department extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%employee2department}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'department_id'], 'required'],
            [['employee_id', 'department_id'], 'integer'],
            [['employee_id', 'department_id'], 'unique', 'targetAttribute' => ['employee_id', 'department_id']],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::class, 'targetAttribute' => ['department_id' => 'id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::class, 'targetAttribute' => ['employee_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'employee_id' => Yii::t('app', 'Employee ID'),
            'department_id' => Yii::t('app', 'Department ID'),
        ];
    }

    /**
     * Gets query for [[Department]].
     *
     * @return ActiveQuery|DepartmentQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id']);
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return ActiveQuery|EmployeeQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }

    /**
     * {@inheritdoc}
     * @return Employee2DepartmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new Employee2DepartmentQuery(get_called_class());
    }
}
