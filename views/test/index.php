<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Тесты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-plus']) . ' Добавить тест', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?=
	GridView::widget([
					 'dataProvider' => $dataProvider,
					 'filterModel'  => $searchModel,
					 'columns'      => [
						 ['class' => 'yii\grid\SerialColumn'],
						 //'test_id',
						 [
							 'attribute' => 'name',
							 'format'    => 'raw',
							 'value'     => function ($data) {
									 return Html::a($data->name, ['view?id=' . $data->test_id]);
								 }
						 ],
						 //            [
						 //                'attribute' => 'created',
						 //                //'value'     => Yii::$app->formatter->asDatetime($model->created, "php:d M Y, H:i"),
						 //                'value'     => function($data){
						 //                    return Yii::$app->formatter->asDatetime($data->created, "php:d M Y, H:i");
						 //                }
						 //            ],
						 //            [
						 //                'attribute' => 'updated',
						 //                'value'     => function($data){
						 //                    return Yii::$app->formatter->asDatetime($data->created, "php:d M Y, H:i");
						 //                }
						 //            ],
						 //            [
						 //                'attribute' => 'author.phio',
						 //                'label'     => 'Автор',
						 //                'format'    => 'raw',
						 //                //'value'     => Html::a($model->getAuthor()['phio'], ['view', 'id' => $model->getAuthor()['user_id']], ['target' => '_blank', 'title' => 'Откроется в новом окне']),
						 //                'value'     => function($data){
						 //                    return Html::a($data->getAuthor()['phio'], ['view', 'id' => $data->getAuthor()['user_id']], ['target' => '_blank', 'title' => 'Откроется в новом окне']);
						 //                }
						 //            ],
						 //'description:ntext',
						 [
							 'attribute' => 'description',
							 'value'     => function ($data) {
									 return substr($data->description, 0, 300) . "…";
								 }
						 ],
						 // 'order',
						 // 'settings',
						 'deadline',
						 ['class' => 'yii\grid\ActionColumn'],
					 ],
					 ]); ?>

</div>
