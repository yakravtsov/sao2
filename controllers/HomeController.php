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

        //Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);

//        Yii::$app->mailer->compose('/mail/test'/*, ['contactForm' => $form]*/)
//            ->setFrom('no-reply@mota-systems.ru')
//            ->setTo('yakravtsov@gmail.com')
//            ->setSubject('Письмо с нашего сервера')
//            ->send();
    }

    public function actionLogin()
    {
        $hash = $_GET['hash'];
        $model = new User;
        $findHash = $model->find()->where(['login_hash' => $hash])->asArray()->One();

        $loginForm = new LoginForm();
        if($findHash !== null && $loginForm->loginViaHash($findHash['email']) ){
            return $this->redirect(['/home']);
        } else {
            echo 'valera';
        }
    }

}