<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Tabs;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title                   = "Проект «" . $model->name . "»";
$this->params['breadcrumbs'][] = ['label' => 'Проекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;

$this->registerJsFile('@web/js/projects.js');
?>
<div class="addusers-container project-addusers">


	<h1>Добавление <?= $isClients ? 'клиентов' : 'сотрудников'; ?> в проект</h1>
	<form method="post" action="/projects/addusers?id=<?=$model->project_id;?>&isClients=<?=$isClients ? 1 : 0?>">
		<input type="hidden" name="users_to_add"/>
		<button class="btn btn-success btn-users" disabled="disabled"><i class="glyphicon glyphicon-ok"></i>
			Добавить <?= $isClients ? 'клиентов' : 'сотрудников'; ?></button>
		<a class="btn btn-default" href="/projects/view?id=<?=$model->project_id;?>&isClients=<?=$isClients ? 1 : 0?>">Отмена</a>
	</form>

	<div>&nbsp;</div>

	<div class="alert alert-warning alert-dismissible timeout-error" style="display:none;">
		<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Ошибка в работе сервера!</strong> Повторите действие.
	</div>

	<?php \yii\widgets\Pjax::begin(['timeout'=>5000]); ?>
	<?= GridView::widget([
		'id'           => 'addusers',
		'dataProvider' => $provider,
		'filterModel'  => $usersSearchModel,
		'columns'      => [
			['class' => 'yii\grid\SerialColumn'],
			//['class' => 'yii\grid\CheckboxColumn'],
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

			//'project_id',
			//'created',
			//'updated',
			//'author_id',
			'phio',
			'email',
			'subcompany',
			// 'report_type',
			// 'description:ntext',
			// 'notify',

			//['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>

	<?php \yii\widgets\Pjax::end(); ?>


</div>