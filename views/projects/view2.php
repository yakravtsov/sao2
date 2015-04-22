<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Tabs;
use yii\grid\GridView;
?>

<?= GridView::widget([
					 'dataProvider' => $provider,
					 'filterModel' => $usersSearchModel,
					 'columns' => [
						 ['class' => 'yii\grid\SerialColumn'],
						 'phio',
					 ],
					 ]); ?>
