<?php

use common\models\EmployeeDepartmentForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $employeeForm EmployeeDepartmentForm */
/* @var $departmentList array */

$this->title = 'Добавление сотрудника в отделы';

$this->params['breadcrumbs'][] = ['label' => 'Список сотрудников', 'url' => ['employee/index']];
$this->params['breadcrumbs'][] = ['label' => 'Добавление сотрудника в отделы'];

?>

<div class="department-add-employee">
    <h2>Добавление сотрудника в отделы</h2>
    <?php $form = ActiveForm::begin();?>

    <?= $form->field($employeeForm, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($employeeForm, 'departmentIds')->widget(Select2::class, [
        'data' => $departmentList,
        'options' => [
            'multiple' => true,
            'placeholder' => 'Выберите отделы...',
        ]
    ])->label('Отделы')?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end();?>

</div>
