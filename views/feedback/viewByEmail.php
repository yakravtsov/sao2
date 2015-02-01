<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\Feedback */

//$this->title = "Сообщение от " . $model->email;
$this->params['breadcrumbs'][] = ['label' => 'Техподдержка', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;


foreach ($all as $one) {

    echo Html::tag('p', Html::tag('mark',Yii::$app->formatter->asDatetime($one[0], "php:d M Y, H:i")) .
        Html::tag('br') .
        $one[1]
        //Html::tag('hr')
        , []);
    //$one[0];
    //$one[1];
}
?>



<div class="feedback-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <? //= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-trash']) . ' Удалить', ['delete', 'id' => 1], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>


</div>
