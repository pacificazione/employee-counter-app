<?php

namespace common\models\services;

use common\models\Employee;
use Yii;

class LoginService
{
    public function login(Employee $employee, bool $rememberMe): bool
    {
        return Yii::$app->user->login($employee, $rememberMe ? 3600 * 24 * 30 : 0);
    }
}