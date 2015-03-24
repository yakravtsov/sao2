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
            //'updated',
            //'author_id',
            'name',
            [
                'attribute' => 'companies',
                'value' => function ($data) {
                    //return print_r($data->getCompany($data->companies));
                },
                'format' => 'raw'
            ],
            'date_start',
             'date_end',
            // 'report_type',
            // 'description:ntext',
            // 'notify',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
