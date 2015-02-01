<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\FeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Техподдержка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <h1><?= Html::tag('i', '', ['class' => 'glyphicon glyphicon-question-sign']) . " " . Html::encode($this->title) ?></h1>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'text',
                'value' => function ($data) {
                    return Html::a(substr($data->text,0,100) . "…", ['view?id=' . $data->feedback_id]);
                },
                'format' => 'html'
            ],
            'email',
            'name',
            'phone',
            [
                'attribute' => 'created',
                'value' => function ($data) {
                    return Yii::$app->formatter->asDatetime($data->created, "php:d M Y, H:i");
                }
            ],
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    return $data->status ? Html::tag('span', $data->getStatusLabel(), ['class' => 'label label-success']) : Html::tag('span', $data->getStatusLabel(), ['class' => 'label label-warning']);
                },
                //'contentOptions' => ['style'=>'text-align: center'],
                'format' => 'html',
                'filter' => $statuses
            ],
            //'updated',
            //'author_id',
            //'feedback_id',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
