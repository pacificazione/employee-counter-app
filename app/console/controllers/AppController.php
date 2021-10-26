<?php

namespace console\controllers;

use common\models\Employee;
use Yii;
use yii\console\Controller;

class AppController extends Controller
{
    public function actionInit()
    {
        $employee = new Employee();

        $employee->firstName = 'a';
        $employee->lastName = 'a';
        $employee->education = 'd';
        $employee->post = 's';
        $employee->age = 1;
        $employee->nationality = 'as';
        $employee->auth_key = 'asdada';
        $employee->password_hash = Yii::$app->security->generatePasswordHash('12345678901');
        $employee->email = 'art@mail.ru';
        $employee->status = Employee::STATUS_ACTIVE;
        $employee->save();
    }
}