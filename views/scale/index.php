<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ScaleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Scales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scale-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Scale', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'created',
            'updated',
            'author_id',
            'scale_id',
            'name',
            // 'test_id',
            // 'default',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
