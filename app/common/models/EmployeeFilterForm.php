<?php

namespace common\models;

use yii\base\Model;

class EmployeeFilterForm extends Model
{
    public $departmentId = null;

    public function rules(): array
    {
        return [
            ['departmentId', 'integer'],
        ];
    }

    public function getDepartmentId(): ?int
    {
        return (int) $this->departmentId ?? null;
    }
}
