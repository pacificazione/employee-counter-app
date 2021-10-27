<?php

use common\models\services\DepartmentDto;
use common\models\DepartmentEmployeeControlForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $employeeForm DepartmentEmployeeControlForm */
/* @var $departmentId int */

$this->title = 'Удаление сотрудника из отдела';

$this->params['breadcrumbs'][] = ['label' => 'Список отделов', 'url' => ['department/index']];
$this->params['breadcrumbs'][] = ['label' => 'Удаление сотрудника из отдела', 'url' => ['department/view', 'id' => $departmentId]];
$this->params['breadcrumbs'][] = ['label' => 'Удаление сотрудника'];

?>

<div class="department-add-employee">
    <h2>Удаление сотрудника из отдела</h2>
    <?php $form = ActiveForm::begin();?>

    <?= $form->field($employeeForm, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end();?>
</div>