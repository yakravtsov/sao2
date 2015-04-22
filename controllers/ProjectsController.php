<?php

namespace app\controllers;

use Yii;
use app\models\Project;
use app\models\search\UserSearch;
use app\models\Company;
use app\models\User;
use app\models\Test;
use app\models\Competence;
use app\models\search\ProjectsSearch;
use yii\base\Exception;
use yii\data\ArrayDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\Session;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;

/**
 * ProjectsController implements the CRUD actions for Project model.
 */
class ProjectsController extends Controller
{

	public $enableCsrfValidation = FALSE;


	public function behaviors() {
		return [
			'verbs' => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
					'removeusers' => ['post'],
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
		$model = $this->findModel($id);

		$usersSearchModel = new UserSearch();

		$projectUsers = ArrayHelper::map($model->projectUsers, 'id', 'role_id');

		$projectClientsMap = ArrayHelper::map($model->projectClients, 'id', 'role_id');
		$projectWorkersMap = ArrayHelper::map($model->projectWorkers, 'id', 'role_id');

		$custom_query   = User::find()->where(['user_id' => array_keys($projectClientsMap)])
		                      ->andWhere(['company_id' => $model->companies->company_id]);
		$projectClients = $usersSearchModel->search(Yii::$app->request->queryParams, $custom_query);

		$custom_query   = User::find()->where(['user_id' => array_keys($projectWorkersMap)])
		                      ->andWhere(['company_id' => $model->companies->company_id]);
		$projectWorkers = $usersSearchModel->search(Yii::$app->request->queryParams, $custom_query);

		$authors        = ArrayHelper::map(User::find()->all(), 'id', 'phio');
		$user           = new User();
		$user->scenario = 'signup';
		$statuses       = $user->getStatusValues();
		$roles          = $user->getRoleValues();

		return $this->render('view', [
			'model'            => $model,
			'projectClients'   => $projectClients,
			'projectWorkers'   => $projectWorkers,
			'authors'          => $authors,
			'statuses'         => $statuses,
			'roles'            => $roles,
			'userModel'        => $user,
			'usersSearchModel' => $usersSearchModel
		]);
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

	public function actionAddusers($id, $isClients = FALSE) {
		$model             = $this->findModel($id);
		$usersSearchModel  = new UserSearch();
		$projectUsers      = ArrayHelper::map($isClients ? $model->projectClients : $model->projectWorkers, 'id', 'role_id');
		$custom_query      = User::find()->where(['NOT IN', 'user_id', array_keys($projectUsers)])
		                         ->andWhere(['company_id' => $model->companies->company_id]);
		$usersDataProvider = $usersSearchModel->search(Yii::$app->request->queryParams, $custom_query);

		$transaction = Yii::$app->db->beginTransaction();
		if (Yii::$app->request->post() AND $users = explode(',', Yii::$app->request->post('users_to_add'))) {
			$users = User::findAll(['user_id' => $users]);
			try {
				$relationName      = $isClients ? 'projectClients' : 'projectWorkers';
				$user_project_role = $isClients ? User::ROLE_CLIENT : User::ROLE_WORKER;
				//$model->unlinkAll($relationName, TRUE);
				foreach ($users as $user) {
					$model->link($relationName, $user, ['user_project_role' => $user_project_role]);
				}
				$transaction->commit();
			} catch (Exception $e) {
				$transaction->rollBack();
				throw new HttpException(400, 'Ошибка транзакции');
			}

			return $this->redirect(['view', 'id' => $model->project_id]);
		} else {
			return $this->render('addusers', [
				'model'            => $this->findModel($id),
				'provider'         => $usersDataProvider,
				'usersSearchModel' => $usersSearchModel,
				'isClients'        => $isClients
			]);
		}
	}

	public function actionRemoveusers($id, $isClients = FALSE) {
		$model             = $this->findModel($id);

		$transaction = Yii::$app->db->beginTransaction();

		if (Yii::$app->request->post() AND $users = explode(',', Yii::$app->request->post('users_to_add'))) {
			$users = User::findAll(['user_id' => $users]);
			try {
				$relationName      = $isClients ? 'projectClients' : 'projectWorkers';
				foreach ($users as $user) {
					$model->unlink($relationName, $user, true);
				}
				$transaction->commit();
			} catch (Exception $e) {
				$transaction->rollBack();
				throw new HttpException(400, 'Ошибка транзакции.');
			}

			return $this->redirect(['view', 'id' => $model->project_id]);
		} else {
			throw new HttpException(400, 'Вам сюда нельзя.');
		}
	}

	/**
	 * Creates a new Project model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Project();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$r = $model->save();
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

			//			return $this->render('asd');
			return $this->redirect(['view', 'id' => $model->project_id]);
		} else {
			$companies    = ArrayHelper::map(Company::find()->All(), 'company_id', 'name');
			$tests        = ArrayHelper::map(Test::find()->All(), 'test_id', 'name');
			$competencies = ArrayHelper::map(Competence::find()->All(), 'competence_id', 'name');

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
	 * @throws HttpException
	 * @throws NotFoundHttpException
	 * @throws \yii\db\Exception
	 */
	public function actionUpdate($id) {
		$model        = $this->findModel($id);
		$companies    = ArrayHelper::map(Company::find()->All(), 'company_id', 'name');
		$tests        = ArrayHelper::map(Test::find()->All(), 'test_id', 'name');
		$competencies = ArrayHelper::map(Competence::find()->All(), 'competence_id', 'name');
		$transaction  = Yii::$app->db->beginTransaction();
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			//die(var_dump($model->type));
			if($model->type == Project::TYPE_TEST){
				$t     = Yii::$app->request->post('Project')['tests'];
				$tests = Test::findAll(['test_id' => $t]);
				try {
					$model->unlinkAll('tests', TRUE);
					$model->unlinkAll('competencies', TRUE);
					foreach ($tests as $test) {
						$model->link('tests', $test);
					}
					$transaction->commit();
				} catch (Exception $e) {
					$transaction->rollBack();
					throw new HttpException(400, 'Ошбика транзакции');
				}
			} else {
				$c     = Yii::$app->request->post('Project')['competencies'];
				$competencies = Competence::findAll(['competence_id' => $c]);
				try {
					$model->unlinkAll('tests', TRUE);
					$model->unlinkAll('competencies', TRUE);
					foreach ($competencies as $competence) {
						$model->link('competencies', $competence);
					}
					$transaction->commit();
				} catch (Exception $e) {
					$transaction->rollBack();
					throw new HttpException(400, 'Ошбика транзакции');
				}
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
}
