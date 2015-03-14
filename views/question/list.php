<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\sortable\Sortable;


/* @var $this yii\web\View */
/* @var $model app\models\Question */
/* @var $form yii\widgets\ActiveForm */


echo Html::tag('div', '&nbsp;');?>
<a class="btn btn-success" data-toggle="modal" data-target="#w0" ng-click="modal.show(test.templates.question, 'Новый вопрос')"><i class="glyphicon glyphicon-plus"></i> Добавить вопрос</a>
<?=Html::tag('div', '&nbsp;');

$sortable = [];
foreach ($questions as $question) {
	$sortable_question = Html::tag('div', $question['name'], ['class' => 'col-xs-10']) . Html::tag('div', Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-pencil']), "#", ['class' => 'btn btn-primary']) . " " .
	Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-trash']), ['/question/delete', 'id' => $question['question_id']], ['class' => 'btn btn-danger']), ['class' => 'col-xs-2 text-right']);
	$sortable[]        = ['content' => $sortable_question];
}

echo Sortable::widget([
	//'showHandle' => 'true',
	'items'       => $sortable,
	'itemOptions' => ['class' => 'row']
]);
