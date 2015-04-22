<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Tabs;
use yii\grid\GridView;

use \app\models\Project;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title                   = "Проект «" . $model->name . "»";
$this->params['breadcrumbs'][] = ['label' => 'Проекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;

$this->registerJsFile('@web/js/projects.js');
?>
<div class="project-view">

	<h1><?= Html::encode($model->name) ?></h1>

	<?
	$report_array = array_intersect_key($model->getReportValues(), array_flip($model->reportTypes));
	$report       = '';
	foreach ($report_array as $r) {
		$report .= $r . "<br>";
	}

	?>

	<?
	// Уведомления для грида
	$notify_array = array_intersect_key($model->getNotifyValues(), array_flip($model->notify));
	$notify       = '';
	foreach ($notify_array as $n) {
		$notify .= $n . "<br>";
	}

	// Тесты для грида
	$tests = '';
	foreach ($model->tests as $test) {
		$tests .= Html::a($test->name, ['/test/view', 'id' => $test->test_id], ['target' => '_blank', 'title' => 'Откроется в новом окне']) . "<br>";
	}

	// Компетенции для грида
	$competencies = '';
	foreach ($model->competencies as $competence) {
		$competencies .= Html::a($competence->name, ['/competence/view', 'id' => $competence->competence_id], ['target' => '_blank', 'title' => 'Откроется в новом окне']) . "<br>";
	}
	?>

	<?= Tabs::widget([
		'items' => [
			[
				//'active'    => TRUE,
				'label'     => 'Общая информация',
				'attribute' => 'description',
				'content'   => Html::tag('p', Html::tag('div', '&nbsp;', ['class' => 'col-sx-1']) . $model['description'] . Html::tag('div', '&nbsp;', ['class' => 'col-sx-1']), ['class' => ''])
					.
					DetailView::widget([
						'model'      => $model,
						'attributes' => [
							//'test_id',
							//'name',
							//'settings',
							[
								'attribute' => 'companies',
								'value'     => Html::a($model->companies->name, ['/companies/view', 'id' => $model->companies->company_id], ['target' => '_blank', 'title' => 'Откроется в новом окне']),
								'format'    => 'raw'
							],
							[
								'attribute' => 'date_start',
								'value'     => Yii::$app->formatter->asDatetime($model['date_start'], "php:d M Y")
							],
							[
								'attribute' => 'date_end',
								'value'     => Yii::$app->formatter->asDatetime($model['date_end'], "php:d M Y")
							],
							[
								'label'  => $model->type == Project::TYPE_TEST ? 'Тесты' : 'Компетенции',
								'value'  => $model->type == Project::TYPE_TEST ? $tests : $competencies,
								'format' => 'raw'
							],
							[
								'label'  => 'Тип pdf-отчётов',
								'value'  => $report !== '' ? $report : 'Без pdf, только сводный в csv',
								'format' => 'raw'
							],
							[
								'label'  => 'Уведомления',
								'value'  => $notify !== '' ? $notify : 'Нет',
								'format' => 'raw'
							],
							[
								'attribute' => 'created',
								'value'     => Yii::$app->formatter->asDatetime($model['created'], "php:d M Y, H:i")
							],
							[
								'attribute' => 'author.phio',
								'label'     => 'Автор',
								'value'     => Html::a($model['author']['phio'], ['view', 'id' => $model['author']['user_id']], ['target' => '_blank', 'title' => 'Откроется в новом окне']),
								'format'    => 'raw'
							],
						],
					])
					.
					Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-pencil']) . ' Редактировать', ['update', 'id' => $model['project_id']], ['class' => 'btn btn-primary'])
					. " " .
					Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-trash']) . ' Удалить', ['delete', 'id' => $model['project_id']], [
						'class' => 'btn btn-danger',
						'data'  => [
							'confirm' => 'Вы уверены, что хотите удалить этот проект?',
							'method'  => 'post',
						],
					])

			],
			[
				'label'   => 'Сотрудники',
				//'active'  => TRUE,
				'content' => $this->render('users/list',
					[
						'dataProvider' => $projectWorkers,
						'usersSearchModel' => $usersSearchModel,
						'authors'      => $authors,
						'statuses'     => $statuses,
						'roles'        => $roles,
						'company_id'   => $model->companies->company_id,
						'model' => $model,
						'isClients' => false
					])
				,
			],
			[
				'label'   => 'Клиенты',
				//'active'  => TRUE,
				'content' => $this->render('users/list',
					[
						'dataProvider' => $projectClients,
						'usersSearchModel' => $usersSearchModel,
						'authors'      => $authors,
						'statuses'     => $statuses,
						'roles'        => $roles,
						'company_id'   => $model->companies->company_id,
						'model' => $model,
						'isClients' => true
					])
				,
			],
		],
	]);
	?>

	<? /*= DetailView::widget([
		'model'      => $model,
		'attributes' => [
			//'project_id',
			'author_id',
			'created',
			'updated',
			'date_start',
			'date_end',
			'report_type',
			'description:ntext',
			'settings',
		],
	]) */ ?>

</div>
