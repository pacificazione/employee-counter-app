<?php

namespace common\models;

use Yii;
use yii\base\Model;

class SignUpForm extends Model
{
    public $firstName;
    public $lastName;
    public $education;
    public $post;
    public $age;
    public $nationality;
    public $email;
    public $password;
    public $departmentId;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'firstName', 'lastName', 'post', 'age'], 'required'],
            [['firstName', 'lastName', 'education', 'post', 'nationality'], 'string', 'max' => 255],
            [['age', 'departmentId'], 'integer'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Employee', 'message' => 'This email address has already been taken.'],
        ];
    }
}