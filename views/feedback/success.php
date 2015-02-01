<?php
/**
 * Created by PhpStorm.
 * User: workplace
 * Date: 27.01.2015
 * Time: 2:20
 */

use yii\helpers\Html;

$this->title = 'Запрос в техподдержку успешно отправлен';
$this->params['breadcrumbs'][] = ['label' => 'Техподдержка', 'url' => ['/feedback']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::tag('i', '', ['class' => 'glyphicon glyphicon-question-sign']) . " " . Html::encode($this->title) ?></h1>
<p>
   Благодарим Вас за внимание. Специалисты ответят на Ваш запрос в течение 24 часов. Если письмо не пришло, пожалуйста, проверьте папку «Спам».
</p>