<?php

namespace app\modules\main\controllers;

use Yii;
use yii\web\Controller;
use app\modules\main\models\ContactForm;

/**
 * Description of ContactController
 *
 * @author Robert Kuznetsov <RK at buildinggame.ru>
 */
class ContactController extends Controller {
    public function actions() 
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionIndex()
    {
        $model = new ContactForm();
        if($user = Yii::$app->user->identity) {
            $model->name = $user->username;
            $model->email = $user->email;
        }
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }
}
