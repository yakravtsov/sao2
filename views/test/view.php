<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Test */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-view" ng-app="sao" ng-controller="TestController"
     ng-init='initModel(<?= json_encode($model->toArray()) ?>)'>
    <h1 style="color: red" ng-bind="test|json"></h1>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->test_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->test_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'created',
            'updated',
            'author_id',
            'test_id',
            'name',
            'description:ntext',
            'order',
            'settings',
            'deadline',
        ],
    ]);

    Modal::begin([
        'header' => '<h2 ng-bind="modalHeader"></h2>',
        'toggleButton' => [
            'tag' => 'button',
            'class' => 'btn btn-lg btn-block btn-info',
            'label' => 'Добавить вопрос',
            'ng-click' => 'newQuestion()'
        ]
    ]);

    echo $this->render('@app/views/question/_form', ['model' => $questionModel]);

    Modal::end();

    ?>
</div>
