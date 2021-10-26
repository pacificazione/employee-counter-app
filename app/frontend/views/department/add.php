<?php

use common\models\DepartmentEmployeeControlForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $employeeForm DepartmentEmployeeControlForm */
/* @var $departmentId int */

$this->title = 'Добавление сотрудника в отдел';

$this->params['breadcrumbs'][] = ['label' => 'Список отделов', 'url' => ['department/index']];
$this->params['breadcrumbs'][] = ['label' => 'Изменение отдела', 'url' => ['department/view', 'id' => $departmentId]];
$this->params['breadcrumbs'][] = ['label' => 'Добавление сотрудника'];

?>

<div class="department-add-employee">
    <h2>Добавление сотрудника в отдел</h2>
    <?php $form = ActiveForm::begin();?>

    <?= $form->field($employeeForm, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end();?>

</div>
