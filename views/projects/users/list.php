<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $data app\models\User */
?>
<div class="addusers-container <?=$isClients ? 'clients' : 'workers' ?>-list">

	<div>&nbsp;</div>

	<div class="alert alert-warning alert-dismissible timeout-error" style="display:none;">
		<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Ошибка в работе сервера!</strong> Повторите действие.
	</div>

	<?
	$linkText = $isClients ? 'клиентов' : 'сотрудников';
	?>

	<form method="post" action="/projects/removeusers?id=<?=$model->project_id;?>&isClients=<?=$isClients ? 1 : 0?>">
		<? echo Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-plus']) . ' Добавить ' . $linkText, ['addusers', 'id' => $model['project_id'],'isClients'=>$isClients ? 1 : 0], ['class' => 'btn btn-success']); ?>
		<input type="hidden" name="users_to_add"/>
		<button class="btn btn-danger btn-users" disabled="disabled" data-confirm="Удалить выбранных <?=$linkText?>?"><i class="glyphicon glyphicon-trash"></i>
			Удалить выбранных <?= $linkText; ?></button>
	</form>

	<div>&nbsp;</div>

	<?php \yii\widgets\Pjax::begin(['timeout'=>5000]); ?>
	<?=GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $usersSearchModel,
		'id'           => $isClients ? 'projectClients' : 'projectWorkers',
		'columns'      => [
			['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'foo',
				'format'    => 'raw',
				'value'     => function ($userModel, $index, $widget) {
					return Html::checkbox('check', FALSE, ['value' => $userModel->user_id]);
				},
				'header'    => Html::checkBox('select_all', FALSE, [
					'class' => 'select_all',
				]),
			],
			[
				'attribute' => 'phio',
				//							 'value'     => function ($data) {
				//									 return Html::a($data->phio, ['view?id=' . $data->id]);
				//								 },
				//							 'format'    => 'raw',
			],
			[
				'attribute' => 'email',
				'value'     => function ($data) {
					return $data->email;
				},
				'format'    => 'text',
			],
			[
				'attribute' => 'subcompany',
				'value'     => function ($data) {
					return $data->subcompany;
				},
				'format'    => 'text',
			],
			[
				'attribute' => 'role_id',
				'value'     => function ($data) {
					return $data->getRoleLabel();
				},
				'filter'    => $roles
			],
		],
	]);
	?>

	<?php \yii\widgets\Pjax::end(); ?>

</div>