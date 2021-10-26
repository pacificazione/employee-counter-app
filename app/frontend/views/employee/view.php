<?php

use common\models\Department;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\services\EmployeeDto */

$this->title = "Сотрудник: {$model->getFirstName()} {$model->getLastName()}";

$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$departmentList = $model->getDepartmentList();

\yii\web\YiiAsset::register($this);
?>
<div class="employee-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
            'attribute' => 'employeeId',
            'label' => 'Идентификатор сотрудника',
            'value' => $model->getEmployeeId(),
            ],
            [
                'attribute' => 'firstName',
                'label' => 'Имя',
                'value' => $model->getFirstName(),
            ],
            [
                'attribute' => 'lastName',
                'label' => 'Фамилия',
                'value' => $model->getLastName(),
            ],
            [
                'attribute' => 'education',
                'label' => 'Образование',
                'value' => $model->getEducation(),
            ],
            [
                'attribute' => 'post',
                'label' => 'Должность',
                'value' => $model->getPost(),
            ],
            [
                'attribute' => 'age',
                'label' => 'Возраст',
                'value' => $model->getAge(),
            ],
            [
                'attribute' => 'nationality',
                'label' => 'Национальность',
                'value' => $model->getNationality(),
            ],
            [
                'attribute' => 'email',
                'label' => 'Почта',
                'value' => $model->getEmail(),
                'format' => 'email',
            ],
       ]
    ]) ?>

    <h1>Отделы сотрудника</h1>

    <div class="department-list">
        <?= GridView::widget([
            'dataProvider' => new ArrayDataProvider(['allModels' => $departmentList]),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                     'attribute' => 'id',
                     'value' => fn (Department $model): int => $model->id,
                     'label' => 'ID',
                ],
                [
                    'attribute' => 'departmentName',
                    'value' => fn (Department $model): string => $model->departmentName,
                    'label' => 'Название',
                ],
            ],
        ]) ?>
    </div>

</div>
