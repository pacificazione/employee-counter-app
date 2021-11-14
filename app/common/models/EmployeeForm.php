<?php

namespace common\models;

class EmployeeForm extends Employee
{
    public $departmentIdList;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstName', 'lastName', 'post', 'age', 'status'], 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['firstName', 'lastName', 'education', 'post', 'nationality'], 'string', 'max' => 255],
            [['age'], 'integer', 'min' => 14],
            ['departmentIdList', 'each', 'rule' => ['integer']],
        ];
    }
}