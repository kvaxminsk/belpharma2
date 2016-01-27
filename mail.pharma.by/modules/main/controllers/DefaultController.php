<?php

namespace app\modules\main\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest) 
        {
            return $this->redirect('/login');
        } else {
            return $this->render('index');
        }
        //return $this->render('index');
    }
}
