<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function beforeAction($action) {
        if(parent::beforeAction($action) && Yii::$app->user->identity->role == 1)
        {
            return true;
        };
        
        return false;
    }
    
    public function actionIndex()
    {
        return $this->render('index');
    }
}
