<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title                   = $model->project_id;
$this->params['breadcrumbs'][] = ['label' => 'Проекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Update', ['update', 'id' => $model->project_id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Delete', ['delete', 'id' => $model->project_id], [
			'class' => 'btn btn-danger',
			'data'  => [
				'confirm' => 'Вы уверены, что хотите удалить проект?',
				'method'  => 'post',
			],
		]) ?>
	</p>

	<?
	$tests = '';
	foreach ($model->tests as $test) {
		$tests .= Html::a($test->name, ['/test/view', 'id' => $test->test_id], ['target' => '_blank', 'title' => 'Откроется в новом окне']) . "<br>";
	}
	?>

	<?= Tabs::widget([
		'items' => [
			[
				'active'    => TRUE,
				'label'     => 'Общая информация',
				'attribute' => 'description',
				'content'   => Html::tag('p', Html::tag('div', '&nbsp;', ['class' => 'col-sx-1']) . $model['description'] . Html::tag('div', '&nbsp;', ['class' => 'col-sx-1']), ['class' => '']) . DetailView::widget([
						'model'      => $model,
						'attributes' => [
							//'test_id',
							//'name',
							//'settings',
//							[
//								'attribute' => 'companies',
//								'value'     => Html::a($model->companies->name, ['/companies/view', 'id' => $model->companies->company_id], ['target' => '_blank', 'title' => 'Откроется в новом окне']),
//							    'format' => 'raw'
//							],
							[
								'attribute' => 'date_start',
								'value'     => Yii::$app->formatter->asDatetime($model['date_start'], "php:d M Y")
							],
							[
								'attribute' => 'date_end',
								'value'     => Yii::$app->formatter->asDatetime($model['date_end'], "php:d M Y")
							],
							[
								'label'  => 'Тесты',
								'value'  => $tests,
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

			],
			[
				'label'   => 'Сотрудники и клиенты',

				'content' => '{etghjcs'
				,
				//'active' => true,
				//'headerOptions' => '',
				//'options' => ['id' => 'myveryownID'
				//],
			],
			[
				'label'   => 'Шкалы',
				'content' => 'Вау-вау'
				//'headerOptions' => '',
				//'options' => ['id' => 'myveryownID'
				//],
			],
		],
	]);
	?>

	<?/*= DetailView::widget([
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
	]) */?>

</div>
