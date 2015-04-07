<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title                   = 'Редактирование проекта'; //: ' . ' ' . $model->project_id;
$this->params['breadcrumbs'][] = ['label' => 'Проекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->project_id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="project-update">

	<h1><?= Html::encode($model->name) ?></h1>

	<?= $this->render('_form', [
		'model'        => $model,
		'companies'    => $companies,
		'tests'        => $tests,
		'competencies' => $competencies
	]) ?>

</div>
