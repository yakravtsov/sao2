<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Scale */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scale-form">

    <?php $form = ActiveForm::begin(['action' => $model->isNewRecord ? '/scale/create' : '/scale/update']); ?>

    <?//= $form->field($model, 'created')->textInput() ?>

    <?//= $form->field($model, 'updated')->textInput() ?>

    <?//= $form->field($model, 'author_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?//= $form->field($model, 'test_id')->textInput() ?>

    <?
    if($model->isNewRecord){
        echo $form->field($model, 'test_id')->hiddenInput(['value'=>$test_id])->label(false);
    } else {
        echo $form->field($model, 'test_id')->hiddenInput()->label(false);
    }
    ?>


    <?//= $form->field($model, 'test_id')->textInput() ?>

    <?= $form->field($model, 'default')->textInput() ?>

    <hr>
    <div class="text-center">
        <div class="form-group">
            <? //= Html::button($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'ng-click'=>'saveQuestion()']) ?>
            <?= Html::button($model->isNewRecord ? Html::tag('i', '', ['class' => 'glyphicon glyphicon-ok']) . ' Сохранить шкалу' : 'Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'ng-click' => 'saveScale()']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
