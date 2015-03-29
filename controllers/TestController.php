<?php

namespace app\controllers;

use app\models\Project;
use app\models\Question;
use app\models\Scale;
use Symfony\Component\Process\Process;
use Yii;
use app\models\Test;
use app\models\search\TestSearch;
use yii\db\ActiveQuery;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TestController implements the CRUD actions for Test model.
 */
class TestController extends Controller
{

    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Test models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Test model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $test = $this->findModel($id);
//		VarDumper::dump($test, 10, true);
//		die(var_dump($test));
		$question = new Question();
        $questions = Question::find()->where(['test_id'=>$id])->asArray()->All();

        $scale = new Scale();

        return $this->render('view', [
            'model' => $test,
            'questionModel'=> $question,
            'questions' => $questions,
            'scalesModel' => $scale,
        ]);
    }

    /**
     * Creates a new Test model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Test();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->save();

            return $this->redirect(['view', 'id' => $model->test_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Test model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $data = Json::decode(file_get_contents('php://input'));
        $model->load($data);
//        die(var_dump($model->load(['Test' => $data])));
        if ($data && $model->load($data)) {
            if (!$model->save()) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $model->refresh();

                return $model->validate();
            } else {
                return $this->redirect(['view', 'id' => $model->test_id]);
            }
        } else {

            return $this->render('update', [
                'model' => $model,
                'questionModel'=>new Question()
            ]);
        }
    }

    /**
     * Deletes an existing Test model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Test model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Test the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
		$model = Test::find()->joinWith(['questions.answers.effects', 'scales', 'author'])->where(['test.test_id'=>$id])->asArray()->one();
		if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
