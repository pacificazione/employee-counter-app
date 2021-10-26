<?php

namespace common\models;

use yii\base\Model;

class DepartmentEmployeeControlForm extends Model
{
    public $email;

    public function rules(): array
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
        ];
    }
}