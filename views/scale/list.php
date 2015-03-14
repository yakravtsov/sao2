<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

?>
<?=Html::tag('div', '&nbsp;');?>
<a class="btn btn-success" data-toggle="modal" data-target="#w0" ng-click="modal.show(test.templates.scale, 'Новая шкала')"><i class="glyphicon glyphicon-plus"></i> Добавить шкалу</a>
<?=Html::tag('div', '&nbsp;');?>

<table class="table">
	<thead>
	<tr>
		<th class="col-xs-3">Название</th>
		<th class="col-xs-7">Начальное значение</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<tr ng-repeat="scale in test.scales">
		<td ng-bind="scale.name"></td>
		<td ng-bind="scale.default"></td>
		<td class="text-right">
			<a href="#" ng-click="modal.show(scale)" class="btn btn-primary"><i
					class="glyphicon glyphicon-pencil"></i></a>
			<a href="#" ng-click="scale.delete()" class="btn btn-danger"><i
					class="glyphicon glyphicon-remove"></i></a>
		</td>
	</tr>
	</tbody>
</table>
