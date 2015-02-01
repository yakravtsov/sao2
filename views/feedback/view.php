<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\Feedback */

$this->title = "Сообщение от " . $model->email;
$this->params['breadcrumbs'][] = ['label' => 'Техподдержка', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$echoAnswers = '';
foreach($answers as $answer){
    $echoAnswers .= Html::tag('div', Yii::$app->formatter->asDatetime($answer['created'], "php:d M Y, H:i") . "<br />" . $answer['text'],['style'=>'padding: 20px 0;']);
}

?>
<div class="feedback-view">

    <h1><?= Html::encode($this->title)  ?></h1>

    <p>
        <?//= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-trash']) . ' Удалить', ['delete', 'id' => $model->feedback_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить это сообщение?',
                'method' => 'post',
            ],
        ]) ?>
        <? if(!$model->status) echo Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-ok']) . ' Отметить как обработанное', ['process', 'id' => $model->feedback_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= Tabs::widget([
        'items' => [
            [
                'active' => $answered ? false : true,
                'label' => 'Сообщение',
                'content' => DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'author_id',
                        //'feedback_id',
                        'email',
                        'name',
                        'phone',
                        [
                            'attribute' => 'status',
                            'value' => $model->status ? Html::tag('span', $model->getStatusLabel(), ['class' => 'label label-success']) : Html::tag('span', $model->getStatusLabel(), ['class' => 'label label-warning']),
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'created',
                            'value' => Yii::$app->formatter->asDatetime($model->created, "php:d M Y, H:i")
                        ],
                    ],
                ]) .
                    $model->text . $this->render('_answerform', ['model' => $model, 'feedbackAnswer' => $feedbackAnswer], true)
                ,
                //'active' => true,
                //'headerOptions' => '',
                //'options' => ['id' => 'myveryownID'
                //],
            ],
            [
                'active' => $answered ? true : false,
                'label' => 'Ответ',
                'content' => $echoAnswers,
                //'headerOptions' => '',
                //'options' => ['id' => 'myveryownID'
                //],
            ],
        ],
    ]);
    ?>

    <? DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'author_id',
            'feedback_id',
            'email',
            'name',
            'phone',
            'status',
            [
                'attribute' => 'created',
                'value' => Yii::$app->formatter->asDatetime($model->created, "php:d M Y, H:i:s")
            ],
            [
                'attribute' => 'updated',
                'value' => Yii::$app->formatter->asDatetime($model->updated, "php:d M Y, H:i:s")
            ],
            'text',
        ],
    ]) ?>

</div>
