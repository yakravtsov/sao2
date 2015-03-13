<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\Test */

$this->title = $model['name'];
$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-view">

	<h1><?= Html::tag('i', '', ['class' => 'glyphicon glyphicon-list-alt']) . " " . Html::encode($this->title) ?></h1>

	<?=
	Tabs::widget([
				 'items' => [
					 [
						 //'active'    => TRUE,
						 'label'     => 'Общая информация',
						 'attribute' => 'description',
						 'content'   => Html::tag('div', '&nbsp;')
										.
										DetailView::widget(
												  [
												  'model'      => $model,
												  'attributes' => [
													  [
														  'attribute' => 'created',
														  'value'     => Yii::$app->formatter->asDatetime($model['created'], "php:d M Y, H:i")
													  ],
													  [
														  'attribute' => 'updated',
														  'value'     => Yii::$app->formatter->asDatetime($model['updated'], "php:d M Y, H:i")
													  ],
													  [
														  'attribute' => 'author.phio',
														  'label'     => 'Автор',
														  'value'     => Html::a($model['author']['phio'], ['view', 'id' => $model['author']['user_id']], ['target' => '_blank', 'title' => 'Откроется в новом окне']),
														  'format'    => 'raw'
													  ],
													  //'company_id',
													  //'name',
													  'parent_id',
													  'level',
												  ],
												  ])
										.
										Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-pencil']) . ' Редактировать', ['update', 'id' => $model['company_id']], ['class' => 'btn btn-primary'])
										. " " .
										Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-trash']) . ' Удалить', ['delete', 'id' => $model['company_id']], [
																																									 'class' => 'btn btn-danger',
																																									 'data'  => [
																																										 'confirm' => 'Вы уверены, что хотите удалить этот тест?',
																																										 'method'  => 'post',
																																									 ],
																																									 ])
					 ],
					 [
						 'active'  => TRUE,
						 'label'   => 'Сотрудники',
						 'content' => $this->render('@app/views/users/list',
													[
													'dataProvider' => $usersDataProvider,
													'searchModel'  => $usersSearchModel,
													'authors'      => $authors,
													'statuses'     => $statuses,
													'roles'        => $roles,
													'userModel'    => $userModel,
													'company_id'=> $model['company_id']
													])
						 ,
					 ],
				 ],
				 ]);
	?>
</div>
