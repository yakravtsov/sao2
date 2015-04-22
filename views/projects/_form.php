<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

use \app\models\Project;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $companies app\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">
	<?php $form = ActiveForm::begin([
		'enableClientValidation' => TRUE,
		'validateOnBlur'         => TRUE,
	]); ?>

	<?= $form->field($model, 'name')->textInput() ?>

	<?=
	$form->field($model, 'companies')->widget(Select2::classname(), [
		'model'     => $model,
		'attribute' => 'companies',
		'data'      => $companies,
	]); ?>

	<?=
	$form->field($model, 'type')
	     ->radioList($model->getTypeValues(), [
		     'unselect'    => NULL,
		     'separator'   => '<br>',
		     'itemOptions' => [
			     //'label' => '',
			     'labelOptions' => ['style' => 'font-weight:normal;']
		     ]
	     ]); ?>

	<?
	$hiddenCompetencies = '';
	$hiddenTests = '';

	if($model->isNewRecord){
		$hiddenCompetencies = 'hidden';
	} else {
		if($model->type == Project::TYPE_TEST){
			$hiddenCompetencies = 'hidden';
		} else {
			$hiddenTests = 'hidden';
		}
	}
	?>

	<?=
	$form->field($model, 'tests', ['options' => ['class' => 'input-tests ' . $hiddenTests]])->widget(Select2::classname(), [
		'model'     => $model,
		'attribute' => 'tests',
		'data'      => $tests,
		'options'   => ['multiple' => TRUE],
	]); ?>

	<?=
	$form->field($model, 'competencies', ['options' => ['class' => 'input-competencies ' . $hiddenCompetencies]])
	     ->widget(Select2::classname(), [
		     'model'     => $model,
		     'attribute' => 'tests',
		     'data'      => $competencies,
		     'options'   => ['multiple' => TRUE],
	     ]); ?>

	<? //= $form->field($model, 'created')->textInput() ?>

	<? //= $form->field($model, 'updated')->textInput() ?>

	<? //= $form->field($model, 'author_id')->textInput() ?>

	<?=
	$form->field($model, 'date_start')->textInput()
	     ->widget(DatePicker::classname(), ['language' => 'ru', 'pluginOptions' => ['format' => 'd.mm.yyyy', 'todayHighlight' => TRUE]]) ?>

	<?=
	$form->field($model, 'date_end')->textInput()
	     ->widget(DatePicker::classname(), ['language' => 'ru', 'pluginOptions' => ['format' => 'd.mm.yyyy', 'todayHighlight' => TRUE]]) ?>

	<?= $form->field($model, 'report_type')->textInput() ?>

	<?= $form->field($model, 'reportTypes')->checkboxList($model->getReportValues(), ['separator'   => '<br>',
	                                                                                  'itemOptions' => [
		                                                                                  //'label' => '',
		                                                                                  'labelOptions' => ['style' => 'font-weight:normal;']
	                                                                                  ]]) ?>

	<?= $form->field($model, 'notify')->checkboxList($model->getNotifyValues(), ['separator'   => '<br>',
	                                                                                  'itemOptions' => [
		                                                                                  //'label' => '',
		                                                                                  'labelOptions' => ['style' => 'font-weight:normal;']
	                                                                                  ]]) ?>

	<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

	<? //= $form->field($model, 'settings')->textInput() ?>

	<div class="form-group text-center">
		<?= Html::submitButton($model->isNewRecord ? Html::tag('i', '', ['class' => 'glyphicon glyphicon-ok']) . ' Создать проект' : Html::tag('i', '', ['class' => 'glyphicon glyphicon-ok']) . ' Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
	$(document).ready(function () {

		$('#project-type input').on('click onBlur', function () {
			var inputTests = $('.input-tests');
			var inputCompetencies = $('.input-competencies');
			if ($(this).val() == 1) {
				inputTests.addClass('hidden');
				inputCompetencies.removeClass('hidden has-error');
				inputCompetencies.find('input').focus();
				inputCompetencies.find('.help-block').html('');
			} else {
				inputCompetencies.addClass('hidden');
				inputTests.removeClass('hidden has-error');
				inputTests.find('input').focus();
				inputTests.find('.help-block').html('');
			}
		});
	});
</script>
