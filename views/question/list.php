<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\sortable\Sortable;

/* @var $this yii\web\View */
/* @var $model app\models\Question */
/* @var $form yii\widgets\ActiveForm */
echo Html::tag('div', '&nbsp;');?>
	<a class="btn btn-success" data-toggle="modal" data-target="#w0"
	   ng-click="modal.show(test.templates.question, 'Новый вопрос')"><i class="glyphicon glyphicon-plus"></i> Добавить
		вопрос</a>
<?=
Html::tag('div', '&nbsp;');
$sortable              = [];
$sortable[]['content'] = '
<div class="col-xs-10" ng-bind="question.name"></div>
<div class="col-xs-2 text-right">
	<a class="btn btn-primary" href="#" ng-click="modal.show(question, question.name, true)" data-toggle="modal" data-target="#w0"><i class="glyphicon glyphicon-pencil"></i></a>
	<button ng-click="test.deleteQuestion(question)" class="btn btn-danger"><i
					class="glyphicon glyphicon-trash"></i></button>
</div>';
echo Sortable::widget([
					  //'showHandle' => 'true',
					  'items'       => $sortable,
					  'itemOptions' => ['class' => 'row', 'ng-repeat' => 'question in test.questions']
					  ]);
