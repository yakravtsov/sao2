<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $data app\models\User */
?>
<div class="user-list">

	<?
	echo Html::tag('div', '&nbsp;');

	Modal::begin([
		//'header'       => '<h2 ng-bind="modalHeader"></h2>',
		'header'       => '<h2 ng-bind="modalHeader">Новый пользователь</h2>',
		'size'         => 'modal-lg',
		'options'      => ['data-backdrop' => 'static'],
		'toggleButton' => [
			'tag'   => 'a',
			'class' => 'btn btn-success',
			'label' => Html::tag('i', '', ['class' => 'glyphicon glyphicon-plus']) . ' Добавить сотрудника',
			//'ng-click' => 'newQuestion()',
			//'style'     => 'width: 200px'
		],
		//'footer' => 'asfdasd'
	]);

	$userModel->company_id = $company_id;
	echo $this->render('@app/views/users/_form', ['model' => $userModel, 'modal' => TRUE]);

	Modal::end();

	// Импорт из csv
	Modal::begin([
		//'header'       => '<h2 ng-bind="modalHeader"></h2>',
		'header'       => '<h2 ng-bind="modalHeader">Импорт из csv-файла</h2>',
		'size'         => 'modal-lg',
		'options'      => ['data-backdrop' => 'static'],
		'toggleButton' => [
			'tag'      => 'a',
			'class'    => 'btn btn-info',
			'label'    => Html::tag('i', '', ['class' => 'glyphicon glyphicon-file']) . ' Импортировать из csv-файла',
			'ng-click' => 'newQuestion()',
			//'style'     => 'width: 200px'
		],
		//'footer' => 'asfdasd'
	]);
	echo $this->render('@app/views/users/import_csv', ['modal' => TRUE, 'company_id' => $company_id]);

	Modal::end();

	echo Html::tag('div', '&nbsp;');
	?>

	<?=
	GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel'  => $searchModel,
		'columns'      => [
			['class' => 'yii\grid\SerialColumn'],
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
			//'created',
			//'updated',
			//						 [
			//							'attribute' => 'author_id',
			//							 'value'=>function($data) {
			//									 return $data->getAuthor()['phio'];
			//								 },
			//							 'filter' => $authors
			//						 ],
			//'parent_id',
			// 'last_login',
			[
				'attribute' => 'status',
				'value'     => function ($data) {
					return $data->getStatusLabel();
					//return $data = 1 ? Html::tag('i', '', ['class' => 'glyphicon glyphicon-ok']) . " " . $data->getStatusLabel() : Html::tag('i', '', ['class' => 'glyphicon glyphicon-remove']) . " " . $data->getStatusLabel();
				},
				//'contentOptions' => ['style'=>'text-align: center'],
				'format'    => 'html',
				'filter'    => $statuses
			],
			// 'password_reset_token',
			// 'password_hash',
			// 'auth_key',
			[
				'label'  => '',
				'format' => 'raw',
				'value'  => function ($data) {
					return Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-pencil']), NULL, ['data-user-id' => $data->user_id, 'data-toggle' => 'modal', 'data-target' => '#user-edit', 'class' => 'btn btn-primary btn-sm'])
					. " " .
					Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-trash']), NULL, ['data-user-id' => $data->user_id, 'data-toggle' => 'modal', 'data-target' => 'user-edit', 'class' => 'btn btn-danger btn-sm']);
				}
			]
			//['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>

	<div class="modal fade" id="user-edit" tabindex="-1" role="dialog" aria-labelledby="user-id"
	     aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body"></div>
			</div>
		</div>
	</div>

</div>

<script type="text/javascript">
	$('#user-edit').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var userId = button.data('user-id') // Extract info from data-* attributes
		$.ajax({
			type: 'get',
			url: '/users/updateajax?id=' + userId,
			success: function (response) {
				modal.find('.modal-body').html(response);
			}
		});
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this)
		modal.find('.modal-title').text('New message to ' + userId)
	})
</script>
