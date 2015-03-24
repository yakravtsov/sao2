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
	<tr ng-repeat="(pk, scale) in test.scales">
		<td ng-bind="scale.name"></td>
		<td ng-bind="scale.default"></td>
		<td class="text-right">
			<a href="#" ng-click="modal.show(scale, scale.name, true)" class="btn btn-primary" data-toggle="modal" data-target="#w0"><i
					class="glyphicon glyphicon-pencil"></i></a>
			<button ng-click="test.deleteScale(scale)" class="btn btn-danger"><i
					class="glyphicon glyphicon-remove"></i></button>
		</td>
	</tr>
	</tbody>
</table>