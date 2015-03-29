<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Question */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-form" ng-show="modal.isCurrentObject(test.templates.question)">
	<div class="form-horizontal  col-xs-12" ng-bind="modal.getCurrentObject() | json">

	</div>

	<?php $form = ActiveForm::begin(['action' => $model->isNewRecord ? '/question/create' : '/question/update']); ?>

	<?= $form->field($model, 'name')->textarea(['maxlength' => 255, 'ng-model' => 'modal.getCurrentObject().name']) ?>

	<?= $form->field($model, 'type')->dropDownList($model->getTypes(), ['ng-model' => 'modal.getCurrentObject().type']) ?>

	<?
		echo $form->field($model, 'test_id')->hiddenInput(['ng-bind'=>'test.test_id'])->label(false);
	?>

	<h3>Варианты ответов</h3>

	<div class="row" ng-repeat="answer in modal.getCurrentObject().answers track by $index">
		<div class="form-group col-xs-10">
			<?= Html::tag('input', '', ['class' => 'form-control', 'value' => 'Первый ответ','placeholder'=>'Введите текст ответа', 'name'=>'answers[]', 'ng-model'=>'answer.name']); ?>
		</div>
		<div class="form-group col-xs-2">
			<a class="btn btn-info" data-toggle="collapse" href="#scales_{{$index}}">
				<i class="glyphicon glyphicon-tasks"></i>
			</a>

			<a class="btn btn-danger" href="#" ng-click="modal.getCurrentObject().removeAnswer($index)">
				<i class="glyphicon glyphicon-remove"></i>
			</a>
		</div>

		<div class="collapse col-xs-12" id="scales_{{$index}}">
			<div class="form-horizontal">
				<div class="form-group" ng-repeat="scale in answer.scaleEffects">
					<label class="col-sm-2 control-label" ng-bind="scale.name"></label>
					<div class="col-sm-1">
						<input type="text" class="form-control input-sm" ng-model="scale.effect">
					</div>
				</div>
			</div>

		</div>
	</div>

	<div class="form-group">
		<?= Html::tag('a', Html::tag('i', '', ['class' => 'glyphicon glyphicon-plus']) . ' Добавить вариант ответа', ['class' => '', 'href' => '#', 'ng-click'=>'modal.getCurrentObject().addAnswer(test.scales)']) ?>
	</div>

	<hr>
	<div class="text-center">
		<div class="form-group">
			<?=
			Html::button($model->isNewRecord ? 'Create' : 'Update',
						 [
						 'class'       => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
						 'ng-click'    => 'test.saveQuestion(modal.getCurrentObject())',
						 'ng-disabled' => 'test.isValid()'
						 ]) ?>
		</div>
	</div>



	<?php ActiveForm::end(); ?>

</div>
