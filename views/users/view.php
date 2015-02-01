<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->phio;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <h1>№<?= $model->user_id . " ";
        echo Html::encode($this->title) ?></h1>
    <? // print_r($model->getAuthorName()) ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
//            [
//                'attribute' => 'role_id',
//                'value' => $model->getRoleLabel()
//            ],
            //'parent_id',
            'email:email',
            [
                'attribute' => 'organization_id',
                'value' => $model->getCompanyName(),
                'format' => 'text',
            ],
            [
                'attribute' => 'author.phio',
                'label' => 'Автор',
                'value' => Html::a($model->getAuthor()['phio'], ['view', 'id' => $model->getAuthor()['user_id']], ['target' => '_blank', 'title' => 'Откроется в новом окне']),
                'format' => 'raw'
            ],

            [
                'attribute' => 'created',
                'value' => Yii::$app->formatter->asDatetime($model->created, "php:d M Y, H:i:s")
            ],
            [
                'attribute' => 'updated',
                'value' => Yii::$app->formatter->asDatetime($model->updated, "php:d M Y, H:i:s")
            ],
            'last_login',
            [
                'attribute' => 'status',
                'value' => $model->getStatusLabel()
            ],
            'password_reset_token',
            'password_hash',
            'login_hash',
            //'auth_key',
        ],
    ]) ?>
    <p>
        <?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-pencil']) . ' Редактировать', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-trash']) . ' Удалить', ['delete', 'id' => $model->user_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
