<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ProjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Проекты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::tag('i', '', ['class' => 'glyphicon glyphicon-list-alt']) . " " . Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-plus']) . ' Добавить проект', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?// die(var_dump($companies)); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'project_id',
            //'created',
            //'author_id',
            [
                'attribute' => 'name',
                'value'     => function ($data) {
                    return Html::a($data->name, ['view?id=' . $data->project_id]);
                },
                'format'    => 'raw',
            ],
            [
                'attribute' => 'companies',
                'value' => 'companies.name'
            ],
            /*[
                'attribute' => 'company',
                'value' => function ($data) {
                    return $data->company;
                },
                'format' => 'raw',
                //'filter' => $companies
            ],*/
            [
                'attribute' => 'date_start',
                'value'     => function ($data){
                    return Yii::$app->formatter->asDatetime($data['date_start'], "php:d M Y");
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'date_end',
                'value'     => function ($data){
                    return Yii::$app->formatter->asDatetime($data['date_end'], "php:d M Y");
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'updated',
                'value'     => function ($data){
                    return Yii::$app->formatter->asDatetime($data['updated'], "php:d M Y");
                },
                'format' => 'raw'
            ],
            // 'report_type',
            // 'description:ntext',
            // 'notify',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
