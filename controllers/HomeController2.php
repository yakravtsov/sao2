<?php
/**
 * Created by PhpStorm.
 * User: workplace
 * Date: 26.01.2015
 * Time: 14:34
 */

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;


class HomeController extends Controller
{
    public function actionIndex()
    {
        $hash = $_GET['hash'];
        $model = new User;
        $find_hash = $model->find()->where(['login_hash' => $hash])->asArray()->One();

        $loginForm = new LoginForm();
        //$loginForm->login($find_hash['id']);

        Yii::$app->user->login($loginForm->getUser(),3600*24*30);
        //Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);

//        Yii::$app->mailer->compose('/mail/test'/*, ['contactForm' => $form]*/)
//            ->setFrom('no-reply@mota-systems.ru')
//            ->setTo('yakravtsov@gmail.com')
//            ->setSubject('Письмо с нашего сервера')
//            ->send();
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

}