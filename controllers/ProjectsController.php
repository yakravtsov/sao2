<?php

namespace app\controllers;

use Yii;
use app\models\Project;
use app\models\Company;
use app\models\Test;
use app\models\Competence;
use app\models\search\ProjectsSearch;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * ProjectsController implements the CRUD actions for Project model.
 */
class ProjectsController extends Controller {

	//public $enableCsrfValidation = false;


	public function behaviors() {
		return [
			'verbs' => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}

	/**
	 * Lists all Project models.
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel  = new ProjectsSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$companies    = ArrayHelper::map(Company::find()->All(), 'company_id', 'name');

		return $this->render('index', [
									  'searchModel'  => $searchModel,
									  'dataProvider' => $dataProvider,
									  'companies'    => $companies
									  ]);
	}

	/**
	 * Displays a single Project model.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render('view', [
									 'model' => $this->findModel($id),
									 ]);
	}

	/**
	 * Creates a new Project model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model        = new Project();
		$companies    = ArrayHelper::map(Company::find()->All(), 'company_id', 'name');
		$tests        = ArrayHelper::map(Test::find()->All(), 'test_id', 'name');
		$competencies = ArrayHelper::map(Competence::find()->All(), 'competence_id', 'name');


		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$r= $model->save();
			$model->refresh();
			//$abrvalg = $model->save();
			//die(var_dump($model->getErrors()));
			//die(var_dump($model->getAttributes()));
			/*$transaction  = Yii::$app->db->beginTransaction();
			$t     = Yii::$app->request->post('Project')['tests'];
			$tests = Test::findAll(['test_id' => $t]);
			foreach ($tests as $test) {
				$model->link('tests', $test);
			}
			$transaction->commit();*/


			return $this->redirect(['view', 'id' => $model->project_id]);
		} else {
			return $this->render('create', [
										   'model'        => $model,
										   'companies'    => $companies,
										   'tests'        => $tests,
										   'competencies' => $competencies
										   ]);
		}
	}

	/**
	 * Updates an existing Project model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model        = $this->findModel($id);
		$companies    = ArrayHelper::map(Company::find()->All(), 'company_id', 'name');
		$tests        = ArrayHelper::map(Test::find()->All(), 'test_id', 'name');
		$competencies = ArrayHelper::map(Competence::find()->All(), 'competence_id', 'name');
		$transaction  = Yii::$app->db->beginTransaction();
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$t     = Yii::$app->request->post('Project')['tests'];
			$tests = Test::findAll(['test_id' => $t]);
			try {
			$model->unlinkAll('tests', TRUE);
			foreach ($tests as $test) {
				$model->link('tests', $test);
			}
			$transaction->commit();
			} catch (Exception $e) {
				$transaction->rollBack();
				throw new HttpException(400, 'Ошбика транзакции');
			}

			return $this->redirect(['view', 'id' => $model->project_id]);
		} else {
			return $this->render('update', [
										   'model'        => $model,
										   'companies'    => $companies,
										   'tests'        => $tests,
										   'competencies' => $competencies
										   ]);
		}
	}

	/**
	 * Deletes an existing Project model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Project model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 *
	 * @return Project the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Project::findOne($id)) !== NULL) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
