<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Импорт пользователей из csv-файла';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['/users']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-import">

	<h1><?= Html::tag('i', '', ['class' => 'glyphicon glyphicon-user']) . " " . Html::encode($this->title) ?></h1>

	<!--	<p>-->
	<!--		Выберите csv-файл и нажмите на кнопку «Импортировать».-->
	<!--	</p>-->
	<div class="alert alert-info">
		В каждой строке файла должны присутствовать 5 полей в следующем порядке: Фамилия, Имя, Отчество, Email,
		подразделение.<br>
		Пожалуйста, перед загрузкой убедитесь в правильности порядка и отсутствии пустых полей.
	</div>

	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	<div class="form-group">
		<input type="file" name="csv_file"/>
	</div>

	<div class="form-group">
		<?= Html::submitButton(Html::tag('i', '', ['class' => 'glyphicon glyphicon-ok']) . ' Импортировать пользователей ', ['class' => 'btn btn-success']) ?>
	</div>
	<?php ActiveForm::end(); ?>


</div>