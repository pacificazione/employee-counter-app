<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model SignUpForm */
/* @var $departmentList array */

use common\models\SignUpForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'firstName')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'lastName')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'departmentId')->dropDownList([0 => 'Выбрать'] + $departmentList)  ?>

                <?= $form->field($model, 'education')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'post')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'age')->textInput() ?>

                <?= $form->field($model, 'nationality')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
