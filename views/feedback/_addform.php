<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Feedback */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="feedback-form">

    <?php $form = ActiveForm::begin(); ?>

    <? if (!\Yii::$app->user->isGuest) {

        echo $form->field($model, 'email')->hiddenInput(['value' => $user['email'], 'maxlength' => 255])->label(false);

        echo $form->field($model, 'name')->hiddenInput(['value' => $user['phio'], 'maxlength' => 255])->label(false);

    } else {

        echo $form->field($model, 'email')->textInput(['maxlength' => 255]);

        echo $form->field($model, 'name')->textInput(['maxlength' => 255]);
    }
    ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'text')->textArea(['rows' => 10]) ?>

    <div class="form-group">
        <?= Html::submitButton(Html::tag('i', '', ['class' => 'glyphicon glyphicon-send']) . ' Отправить запрос', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
