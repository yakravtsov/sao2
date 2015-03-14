<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Scale */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scale-form" ng-show="modal.type=='scale'">

    <? $form = ActiveForm::begin(['action' => $model->isNewRecord ? '/scale/create' : '/scale/update']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'test_id')->hiddenInput(['ng-bind'=>'test.test_id'])->label(false); ?>

    <?= $form->field($model, 'default')->textInput() ?>

    <hr>
    <div class="text-center">
        <div class="form-group">
            <?= Html::button(Html::tag('i', '', ['class' => 'glyphicon glyphicon-ok']) . ' Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'ng-click' => 'modal.currentObject.save()']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
