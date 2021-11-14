<?php

use common\models\Employee;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $employeeForm common\models\EmployeeForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $departmentList array */
/* @var $employeeDepartmentIdList array */
?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($employeeForm, 'firstName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($employeeForm, 'lastName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($employeeForm, 'education')->textInput(['maxlength' => true]) ?>

    <?= $form->field($employeeForm, 'post')->textInput(['maxlength' => true]) ?>

    <?= $form->field($employeeForm, 'age')->textInput() ?>

    <?= $form->field($employeeForm, 'nationality')->textInput(['maxlength' => true]) ?>

    <?= $form->field($employeeForm, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($employeeForm, 'departmentIdList')->widget(Select2::class, [
        'data' => $departmentList,
        'options' => [
            'multiple' => true,
            'placeholder' => 'Выберите отделы...',
        ]
    ])->label('Отделы')?>

    <?= $form->field($employeeForm, 'status')->dropDownList([0 => 'Выбрать'] + Employee::getStatusList()) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отмена', ['employee/index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
