<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Test */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-form" ng-app="sao" ng-controller="TestController" ng-init='initModel(<?=json_encode($model->toArray())?>)'>
<!--<input type="text" ng-model="test.name"/>-->
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255, 'ng-model'=>'test.name']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'ng-model'=>'test.description']) ?>

    <?= $form->field($model, 'order')->dropDownList($model->getOrderList(), ['ng-model'=>'test.order']) ?>

<!--    --><?//= $form->field($model, 'settings[questionsRandomOrder]')->textInput() ?>

    <?= $form->field($model, 'deadline')->textInput(['ng-model'=>'test.deadline']) ?>

    <?php ActiveForm::end(); ?>

</div>
