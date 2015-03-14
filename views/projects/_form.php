<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\field\FieldRange;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $companies app\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

	<?php $form = ActiveForm::begin([
									'enableClientValidation'=>false,
									'enableAjaxValidation'=>true,
									'validateOnChange' => true,
									'validateOnSubmit' => true
									//'validateOnBlur' => true,
									]); ?>
	<?//= $form->field($model, 'companies')->checkboxList($companies, ['separator' => '<br>'])->label('Компании') ?>

	<?//= $form->field($model, 'created')->textInput() ?>

	<?//= $form->field($model, 'updated')->textInput() ?>

	<?//= $form->field($model, 'author_id')->textInput() ?>

	<?//=
	/*DatePicker::widget([
					   'model' => $model,
					   'attribute' => 'date_start',
					   'attribute2' => 'date_end',
					   'options' => ['placeholder' => 'Start date'],
					   'options2' => ['placeholder' => 'End date'],
					   'separator' => '',
					   'type' => DatePicker::TYPE_RANGE,
					   'form' => $form,
					   'pluginOptions' => [
						   'format' => 'dd-M-yyyy',
						   'autoclose' => true,
					   ]
					   ]);*/
	?>

	<?=
	$form->field($model, 'date_start')->textInput()
		 ->widget(DatePicker::classname(), ['language' => 'ru', 'pluginOptions' => ['format' => 'd.mm.yyyy', 'todayHighlight' => TRUE]]) ?>

	<?= $form->field($model, 'date_end')->textInput()->widget(DatePicker::classname(), ['language' => 'ru', 'pluginOptions' => ['format' => 'd.mm.yyyy', 'todayHighlight' => TRUE]]) ?>

	<?= $form->field($model, 'report_type')->textInput() ?>

	<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'notify')->textInput() ?>

	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
