<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Feedback */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="feedback-form">

    <?php $form = ActiveForm::begin([
        'action' => ['feedback/answer'],
    ]); ?>

    <?//= $form->field($feedbackAnswer, 'email')->textInput(['value'=>$model->email]) ?>

    <?= $form->field($feedbackAnswer, 'author_id')->hiddenInput(['value'=>$model->author_id])->label(false); ?>
    <?= $form->field($feedbackAnswer, 'feedback_id')->hiddenInput(['value'=>$model->feedback_id])->label(false); ?>
    <?= $form->field($feedbackAnswer, 'email')->hiddenInput(['value'=>$model->email])->label(false); ?>

    <?//= $form->field($feedbackAnswer, 'text')->textArea(['value'=>$model->feedback_id]) ?>

    <?= $form->field($feedbackAnswer, 'text')->textArea(['rows'=>10]) ?>

    <div class="form-group">
        <?= Html::submitButton(Html::tag('i', '', ['class' => 'glyphicon glyphicon-send']) . ' Ответить на сообщение', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
