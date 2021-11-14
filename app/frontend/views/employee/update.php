<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $employeeForm common\models\EmployeeForm */
/* @var $departmentList array */
/* @var $employeeDepartmentIdList array */

$this->title = 'Изменить сотрудника: ' . $employeeForm->id;
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $employeeForm->id, 'url' => ['index', 'id' => $employeeForm->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="employee-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'employeeDepartmentIdList' => $employeeDepartmentIdList,
        'departmentList' => $departmentList,
        'employeeForm' => $employeeForm,
    ]) ?>

</div>
