<?php

use common\models\Employee;
use common\models\EmployeeFilterForm;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $filterForm EmployeeFilterForm */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $departmentList array<int, string> */

$this->title = 'Сотрудники';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($filterForm, 'departmentId')->dropdownList([0 => 'Все'] + $departmentList)->label('Отдел') ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сбросить', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'firstName',
            'lastName',
            'post',
            'education',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function (Employee $model) {
                    return $model->getStatusName();
                },
            ],
            'created_at:date',
            'updated_at:date',

            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function (string $action, Employee $model) {
                    return "{$action}?id={$model->id}";
                }
            ],
        ],
    ]); ?>


</div>
