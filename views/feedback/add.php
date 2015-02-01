<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Feedback */

$this->title = 'Новый запрос в техподдержку';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-create">

    <h1><?= Html::tag('i', '', ['class' => 'glyphicon glyphicon-question-sign']) . " " . Html::encode($this->title) ?></h1>

    <?= $this->render('_addform', [
        'model' => $model,
        'user' => $user
    ]) ?>

</div>
