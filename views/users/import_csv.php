<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="user-import">
	<div class="alert alert-warning">
		В каждой строке csv-файла должны присутствовать 5 полей в следующем порядке:<br>
		Фамилия, имя, отчество, email, подразделение.<br>
		Пожалуйста, перед загрузкой убедитесь в правильности порядка и отсутствии пустых полей.
	</div>

	<? if (isset($error)) { ?>
		<div class="alert alert-danger">
			Не удалось импортировать пользователей из файла. Убедитесь, что выбранный Вами файл является правильным
			csv-файлом.
		</div>
	<? } ?>

	<?php $form = ActiveForm::begin(['action' => '/users/import', 'options' => ['enctype' => 'multipart/form-data']]); ?>
	<input type="hidden" name="company_id" value="<?=$company_id ?>"/>

	<div class="form-group">
		<div class="input-group">

			<div class="input-group-btn">
				<!--			TODO: вставлять сюда айдишник компании, подразделения лучше отдельным полем хранить -->

				<div class="btn btn-primary" style="position:relative;overflow:hidden;">
					<i class="glyphicon glyphicon-file"></i> Выбрать файл
					<input type="file" name="import_csv" required="required"
						   style="position:absolute;top:0;right:0;min-width:100%;min-height:100%;opacity:0;cursor:pointer;">
				</div>
			</div>

			<div class="form-control" name="import_csv_filename"></div>
		</div>
	</div>

	<div class="form-group text-center">
		<?= Html::submitButton(Html::tag('i', '', ['class' => 'glyphicon glyphicon-save']) . ' Импортировать сотрудников ', ['class' => 'btn btn-success', 'name'=>'import_csv_submit']) ?>
	</div>
	<?php ActiveForm::end(); ?>

	<script type="text/javascript">
		var fileName;
		$('[name=import_csv]').on('change', function () {
			var files = event.target.files;
			fileName = files[0].name;
			$('[name=import_csv_filename]').html('Вы выбрали файл «<strong>' + fileName + '</strong>»');
		});
		$('[name=import_csv_submit]').on('click',function(){
			if (typeof fileName != 'undefined'){
				$(this).addClass('disabled').html('<i class="glyphicon glyphicon-hourglass"></i> Подождите, выполняется загрузка файла.');
			}
		});
	</script>

</div>