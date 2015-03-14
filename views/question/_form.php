<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Question */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-form" ng-show="modal.isCurrentObject(test.templates.question)">
	<?php $form = ActiveForm::begin(['action' => $model->isNewRecord ? '/question/create' : '/question/update']); ?>

	<?= $form->field($model, 'name')->textarea(['maxlength' => 255, 'ng-model' => 'question.name']) ?>

	<?= $form->field($model, 'type')->dropDownList($model->getTypes(), ['ng-model' => 'question.type']) ?>

	<?
		echo $form->field($model, 'test_id')->hiddenInput(['ng-bind'=>'test.test_id'])->label(false);
	?>

	<h3>Варианты ответов</h3>

	<div class="row" ng-repeat="answer in question.answers">
		<div class="form-group col-xs-10">
			<?= Html::tag('input', '', ['class' => 'form-control', 'value' => 'Первый ответ','placeholder'=>'Введите текст ответа', 'name'=>'answers[]', 'ng-model'=>'answer.name']); ?>
		</div>
		<div class="form-group col-xs-2">
			<a class="btn btn-info" data-toggle="collapse" href="#scales">
				<i class="glyphicon glyphicon-tasks"></i>
			</a>

			<a class="btn btn-danger" href="#" ng-click="question.removeAnswer(answer)">
				<i class="glyphicon glyphicon-remove"></i>
			</a>
		</div>

		<div class="collapse col-xs-12" id="scales">
			<div class="form-horizontal">
				<div class="form-group" ng-repeat="scale in scales">
					<label class="col-sm-2 control-label" ng-bind="scale.name"></label>
					<div class="col-sm-1">
						<input type="text" class="form-control input-sm" ng-model="answer.scaleEffects[scale.scale_id]">
					</div>
				</div>
			</div>

		</div>
	</div>

	<div class="form-group">
		<?= Html::tag('a', Html::tag('i', '', ['class' => 'glyphicon glyphicon-plus']) . ' Добавить вариант ответа', ['class' => '', 'href' => '#', 'ng-click'=>'question.addAnswer()']) ?>
	</div>

	<hr>
	<div class="text-center">
		<div class="form-group">
			<?= Html::button($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'ng-click'=>'question.save()']) ?>
<!--			--><?//= Html::submitButton($model->isNewRecord ? Html::tag('i', '', ['class' => 'glyphicon glyphicon-ok']) . ' Сохранить вопрос' : 'Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'ng-click' => 'saveQuestion()']) ?>
		</div>
	</div>



	<?php ActiveForm::end(); ?>

</div>
