<?php

namespace common\models;

use yii\base\Model;

class EmployeeForm extends Model
{
    public $firstName;
    public $lastName;
    public $education;
    public $post;
    public $age;
    public $nationality;
    public $email;
    public $departmentId;
    public $employeeId;
    public $departmentName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'firstName', 'lastName', 'post', 'age', 'departmentName'], 'required'],
            [['firstName', 'lastName', 'education', 'post', 'nationality', 'departmentName'], 'string', 'max' => 255],
            [['age', 'departmentId', 'employeeId'], 'integer'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
        ];
    }
}