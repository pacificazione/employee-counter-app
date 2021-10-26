<?php

namespace common\tests\fixtures;

use yii\test\ActiveFixture;

class Employee2DepartmentFixture extends ActiveFixture
{
    public $modelClass = 'common\models\Employee2Department';

    public $depends = [
        'common\tests\fixtures\DepartmentFixture',
        'common\tests\fixtures\EmployeeFixture',
    ];
}