<?php

namespace app\controllers;

use Yii;
use app\models\Scale;
use app\models\search\ScaleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ScaleController implements the CRUD actions for Scale model.
 */
class ScaleController extends Controller {

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
	 * Lists all Scale models.
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel  = new ScaleSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
									  'searchModel'  => $searchModel,
									  'dataProvider' => $dataProvider,
									  ]);
	}

	/**
	 * Displays a single Scale model.
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
	 * Finds the Scale model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 *
	 * @return Scale the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Scale::findOne($id)) !== NULL) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	/**
	 * Creates a new Scale model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Scale();
		if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
			if (Yii::$app->request->isAjax) {
				Yii::$app->response->format = Response::FORMAT_JSON;
				$model->refresh();

				return $model;
			} else {
				return $this->redirect(['view', 'id' => $model->scale_id]);
			}
		} else {
			if (Yii::$app->request->isAjax) {
				Yii::$app->response->format = Response::FORMAT_JSON;

				return $model->errors;
			}
			return $this->render('create', [
										   'model' => $model,
										   ]);
		}
	}

	/**
	 * Updates an existing Scale model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionUpdate($id) {
			Yii::$app->response->format = Response::FORMAT_JSON;
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
			$model->refresh();
			return $model;
		} else {
			return $this->render('update', [
										   'model' => $model,
										   ]);
		}
	}

	/**
	 * Deletes an existing Scale model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionDelete($id) {
		Yii::$app->response->format = Response::FORMAT_JSON;
		return $this->findModel($id)->delete();
	}
}
