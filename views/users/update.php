<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Редактирование:' . ' ' . $model->phio;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['/users']];
$this->params['breadcrumbs'][] = ['label' => $model->phio, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
