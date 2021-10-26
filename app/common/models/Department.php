<?php

namespace common\models;

use common\models\query\DepartmentQuery;
use common\models\query\Employee2departmentQuery;
use common\models\query\EmployeeQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Модель отдела.
 *
 * @property int $id
 * @property string $departmentName Название отдела
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Employee2department[] $employee2departments
 * @property Employee[] $employees
 */
class Department extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%department}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['departmentName'], 'required'],
            [['departmentName'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'departmentName' => Yii::t('app', 'Название отдела'),
        ];
    }

    /**
     * Gets query for [[Employee2departments]].
     *
     * @return ActiveQuery|Employee2departmentQuery
     */
    public function getEmployee2department()
    {
        return $this->hasMany(Employee2department::class, ['department_id' => 'id']);
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return ActiveQuery|EmployeeQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employee::className(), ['id' => 'employee_id'])->viaTable('{{%employee2department}}', ['department_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return DepartmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DepartmentQuery(get_called_class());
    }
}
