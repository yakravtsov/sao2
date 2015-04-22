<?php

namespace app\controllers;

use app\models\Scale;
use Yii;
use app\models\Question;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * QuestionController implements the CRUD actions for Question model.
 */
class QuestionController extends Controller
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
	 * Finds the Question model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 *
	 * @param bool    $asArray
	 *
	 * @throws \yii\web\NotFoundHttpException
	 * @return Question the loaded model
	 */
	protected function findModel($id, $asArray = false) {
		$model = Question::find()->joinWith('answers.effects')->where(['question.question_id'=>$id]);
		if($asArray) {
			$model->asArray();
		}
		$model = $model->one();
		if (($model) !== NULL) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionCreate() {
		$model = new Question();
		$model->lft = $model->rgt = $model->depth = $model->author_id = 1;
		if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
			if($model->save()) {
				if (Yii::$app->request->isAjax) {
					Yii::$app->response->format = Response::FORMAT_JSON;

					return $this->findModel($model->question_id, true);
				} else {
					return $this->redirect(['test', 'view', 'id' => $model->test_id]);
				}
			} else {
				Yii::$app->response->format = Response::FORMAT_JSON;

				return $model->getErrors();
			}
		} else {
			return $this->render('create', [
				'model' => $model,
				'scales'=> Scale::find()->all()
			]);
		}
	}

	/**
	 * Updates an existing Question model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
			if($model->save()) {
				$model = $this->findModel($id, true);
				if (Yii::$app->request->isAjax) {
					Yii::$app->response->format = Response::FORMAT_JSON;

					return $model;
				} else {
					return $this->redirect(['view', 'id' => $model->question_id]);
				}
			} else {
				Yii::$app->response->format = Response::FORMAT_JSON;

				return $model->getErrors();
			}
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing Question model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionDelete($id) {
		$r = $this->findModel($id)->delete();
		if(Yii::$app->request->isAjax) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return $r;
		} else {
			return $this->redirect(['index']);
		}
	}
}
