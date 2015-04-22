<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Tabs;
/* @var $this yii\web\View */
/* @var $model app\models\Test */

$this->title                   = $model['name'];
$this->params['breadcrumbs'][] = ['label' => 'Тесты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="test-view" ng-app="sao" ng-controller="TestController"
     ng-init='initModel(<?= \yii\helpers\BaseJson::encode($model) ?>)'>
	<? Modal::begin([
	'header' => '<h2 ng-bind="modal.getHeader()"></h2>',
	'size' => 'modal-lg',
	'options' => ['data-backdrop'=>'static'],
	'toggleButton' => false
	]);

	echo $this->render('@app/views/question/_form', ['model' => $questionModel]);
	echo $this->render('@app/views/scale/_form', ['model' => $scalesModel]);

	Modal::end();
	?>
	<h1><?= Html::encode($this->title) ?></h1>

	<?= Tabs::widget([
		'items' => [
			[
				//'active'    => TRUE,
				'label'     => 'Общая информация',
				'attribute' => 'description',
				'content'   => Html::tag('p', Html::tag('div','&nbsp;',['class'=>'col-sx-1']) . $model['description'] . Html::tag('div','&nbsp;',['class'=>'col-sx-1']), ['class' => '']) . DetailView::widget([
						'model'      => $model,
						'attributes' => [
							'deadline',
							//'order',
						    [
							    'label' => 'Порядок вопросов',
							    'attribute' => function($data){
								    //return $data->getOrderList()[$data->order];
							    }
							],
//							[
//								'label' => 'test',
//								'attribute' => function($data){
//									return $data->getOrderList($data->order);
//								}
//							],
							//'description:ntext',
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
							//'test_id',
							//'name',
							//'settings',
						],
					])
					.
					Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-pencil']) . ' Редактировать', ['update', 'id' => $model['test_id']], ['class' => 'btn btn-primary'])
					. " " .
					Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-trash']) . ' Удалить', ['delete', 'id' => $model['test_id']], [
						'class' => 'btn btn-danger',
						'data'  => [
							'confirm' => 'Вы уверены, что хотите удалить этот тест?',
							'method'  => 'post',
						],
					])

			],
			[
				'label'   => 'Вопросы',

				'content' => $this->render('@app/views/question/list', ['questions'=>$questions, 'questionModel' => $questionModel,'test_id'=>$model['test_id']])
				,
				'active' => true,
				//'headerOptions' => '',
				//'options' => ['id' => 'myveryownID'
				//],
			],
			[
				'label' => 'Шкалы',
				'content' => $this->render('@app/views/scale/list', ['test_id'=>$model['test_id'], 'scalesModel'=>$scalesModel])
				//'headerOptions' => '',
				//'options' => ['id' => 'myveryownID'
				//],
			],
		],
	]);
	?>
</div>
