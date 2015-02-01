<?php

namespace app\controllers;

use app\models\FeedbackAnswer;
use Yii;
use app\models\User;
use app\models\Feedback;
use app\models\search\FeedbackSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FeedbackController implements the CRUD actions for Feedback model.
 */
class FeedbackController extends Controller
{
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
     * Lists all Feedback models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Feedback;
        $statuses = $model->getStatusValues();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statuses' => $statuses
        ]);
    }

    /**
     * Displays a single Feedback model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $feedbackAnswer = new FeedbackAnswer();
        $answers = $feedbackAnswer->find()->where(['feedback_id' => $id])->orderBy('created')->AsArray()->All();

        $answered = isset($_GET['answered']) ? true : false;

        return $this->render('view', [
            'model' => $this->findModel($id),
            'feedbackAnswer' => $feedbackAnswer,
            'answers' => $answers,
            'answered' => $answered
        ]);
    }

    /**
     * Finds the Feedback model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Feedback the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Feedback::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findAnswerModel($id)
    {
        if (($model = FeedbackAnswer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Feedback model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Feedback();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->feedback_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Feedback model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->feedback_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Feedback model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionAdd()
    {
        $model = new Feedback();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['success']);

        } else {

            $user = User::find(['user_id' => Yii::$app->user->id])->asArray()->One();

            return $this->render('add', [
                'model' => $model,
                'user' => $user
            ]);
        }
    }

    public function actionSuccess()
    {
        return $this->render('success');
    }

    public function actionAnswer()
    {
        $feedbackAnswer = new FeedbackAnswer();

        if ($feedbackAnswer->load(Yii::$app->request->post()) && $feedbackAnswer->save()) {
            $model = $this->findModel($feedbackAnswer->feedback_id);
            $model->status = 1;
            $model->save();
            return $this->redirect(['view', 'id' => $feedbackAnswer->feedback_id, 'answered'=>'']);
        }
    }

    public function actionProcess($id)
    {
        $model = $this->findModel($id);
        $model->status = 1;
        if ($model->save()) {
            return $this->redirect(['view', 'id' => $model->feedback_id]);
        } else {
            throw new NotFoundHttpException('Операция не была завершена, попробуйте позднее.');
        }
    }


    /** Тут join нужны, похоже. А лучше -- joint.
     * @param $email
     * @return string
     */
    public function actionViewbyemail($email)
    {
        $questions = Feedback::find()->where(['email' => $email])->orderBy('created')->AsArray()->All();
        $answers = FeedbackAnswer::find()->where(['email' => $email])->orderBy('created')->AsArray()->All();

        $merge = array_merge($questions,$answers);

        $all = [];
        foreach ($merge as $key => $row)
        {
            $all[$key] = [$row['created'],$row['text'],$row['email']];
        }
        array_multisort($all, SORT_ASC, $merge);

        return $this->render('viewByEmail', [
            'all' => $all,
            //'questions' => $questions,
            //'answers' => $answers
        ]);
    }

    public function actionEmail($id)
    {

        $feedbackAnswer = new FeedbackAnswer();

        return $this->render('email', [
            //'model' => $model,
            'model' => $this->findModel($id),
            //'answers' => $answers,
        ]);
    }
}
