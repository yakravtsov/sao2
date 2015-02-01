<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Scale */

$this->title = 'Create Scale';
$this->params['breadcrumbs'][] = ['label' => 'Scales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scale-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
