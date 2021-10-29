<?php

namespace common\models;

use yii\base\Model;

class EmployeeDepartmentForm extends Model
{
    public $email;
    public $departmentIds = [];

    public function rules(): array
    {
        return [
            ['email', 'required', 'message' => 'Необходимо заполнить почту сотрудника.'],
            ['email', 'email'],
            ['departmentIds', 'required', 'message' => 'Необходимо выбрать отделы.'],
            ['departmentIds', 'each', 'rule' => ['integer']],
        ];
    }
}