<?php

namespace app\controllers;

use parseCSV;
use Yii;
use app\models\search\UserSearch;
use app\models\Company;
use app\models\User;
use app\models\search\CompanySearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanysController implements the CRUD actions for Company model.
 */
class CompaniesController extends Controller
{

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
	 * Lists all Company models.
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel  = new CompanySearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$authors      = ArrayHelper::map(User::find()->all(), 'id', 'phio');

		return $this->render('index', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
			'authors' => $authors
		]);
	}

	/**
	 * Displays a single Company model.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionView($id) {
		$usersSearchModel             = new UserSearch();
		$usersSearchModel->company_id = $id;
		$usersDataProvider            = $usersSearchModel->search(Yii::$app->request->queryParams);
		$authors                      = ArrayHelper::map(User::find()->all(), 'id', 'phio');
		$user                         = new User();
		$user->scenario               = 'signup';
		$statuses                     = $user->getStatusValues();
		$roles                        = $user->getRoleValues();

		return $this->render('view', [
			'model'             => $this->findModel($id),
			'usersDataProvider' => $usersDataProvider,
			'usersSearchModel'  => $usersSearchModel,
			'authors'           => $authors,
			'statuses'          => $statuses,
			'roles'             => $roles,
			'userModel'         => $user
		]);
	}

	/**
	 * Finds the Company model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 *
	 * @return Company the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Company::findOne($id)) !== NULL) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	/**
	 * Creates a new Company model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Company();
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->company_id]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing Company model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->company_id]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing Company model.
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
}
