<?php

namespace app\controllers;

use app\models\Company;
use Yii;
use app\models\User;
use app\models\search\UserSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for User model.
 */
class UsersController extends Controller {

	/* TODO: цсфр вернуть*/
	public $enableCsrfValidation = FALSE;

	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				//                'only' => ['logout', 'about'],
				/*'denyCallback' => function ($rule, $action) {
					throw new \Exception('You are not allowed to access this page');
				},*/
				'rules' => [
					[
						//                        'actions' => ['*'],
						'allow' => TRUE,
						'roles' => ['@'],
					],
				],
			],
			'verbs'  => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
					//'import' => ['post'],
				],
			],
		];
	}

	/**
	 * Lists all User models.
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new UserSearch();
		/*$dataProvider = new ActiveDataProvider([
			'query' => User::find()
		]);*/
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$authors      = ArrayHelper::map(User::find()->all(), 'id', 'phio');
		$mo           = new User;
		$statuses     = $mo->getStatusValues();
		$roles        = $mo->getRoleValues();

		return $this->render('index', [
									  'dataProvider' => $dataProvider,
									  'searchModel'  => $searchModel,
									  'authors'      => $authors,
									  'statuses'     => $statuses,
									  'roles'        => $roles
									  ]);
	}

	/**
	 * Displays a single User model.
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
	 * Creates a new User model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model           = new User();
		$model->scenario = 'signup';
		if ($model->load(Yii::$app->request->post())) {
			$model->generateLoginHash($model->email);
			if ($model->save()) {
				Yii::$app->mailer->compose('/users/mail/signup', ['model' => $model])
								 ->setFrom('no-reply@mota-systems.ru')
								 ->setTo($model->email)
								 ->setSubject('Регистрация в системе тестирования S&A Online')
								 ->send();

				return $this->redirect(['view', 'id' => $model->id]);
			}
		} else {
			return $this->render('create', ['model' => $model]);
		}
	}

	/**
	 * Updates an existing User model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model           = $this->findModel($id);
		$model->scenario = 'signup';
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('update', [
										   'model' => $model,
										   ]);
		}
	}

	/**
	 * Deletes an existing User model.
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
	 * Finds the User model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 *
	 * @return User the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = User::findOne($id)) !== NULL) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}


	/** Просто посмотреть письмо для пользователя */
	public function actionEmail($id) {
		return $this->render('/users/mail/signup', ['model' => $this->findModel($id)]);
	}

	//	public function actionImport() {
	//		//$model           = new User();
	//		//$model->scenario = 'signup';
	//		if(isset($_POST['csv_file'])){
	//			$target_path = "/uploads/";
	//			$target_path = $target_path . basename( $_FILES['uploadedfile']['name']);
	//
	//			if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
	//				echo "The file ".  basename( $_FILES['uploadedfile']['name']).
	//					 " has been uploaded";
	//			} else{
	//				echo "There was an error uploading the file, please try again!";
	//			}
	//
	//
	///*
	//			$row = 1;
	//			if (($handle = fopen("test.csv", "r")) !== FALSE) {
	//				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	//					$num = count($data);
	//					echo "<p> $num полей в строке $row: <br /></p>\n";
	//					$row++;
	//					for ($c=0; $c < $num; $c++) {
	//						echo $data[$c] . "<br />\n";
	//					}
	//				}
	//				fclose($handle);
	//			}*/
	//		} else {
	//			return $this->render('import_csv');
	//		}
	//	}
	public function actionImport() {
		//$row = 1;
		$users = [];
		$mapper = ['surname', 'name', 'secondName', 'email', 'company'];
		if (($handle = fopen("../uploads/file.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$combine = array_combine($mapper, $data);
				$combine['phio'] = $combine['surname'] . " " . $combine['name'] . " " . $combine['secondName'];
				$users[] = $combine;
			$model = new User($combine);
			}
			fclose($handle);
			echo "<pre>";
			print_r($users);
			echo "</pre>";
		}
	}
}
