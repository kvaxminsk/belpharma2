<?php
namespace app\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\modules\user\models\User;
use app\modules\user\models\PasswordChangeForm;

/**
 * Description of ProfileController
 *
 * @author mr
 */
class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }
    
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => $this->findModel(),
        ]);
    }
    
    public function actionUpdate()
    {
        $model = $this->findModel();
        $model->scenario = User::SCENARIO_PROFILE;
        if($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionChangePassword()
    {
        $model = new PasswordChangeForm($this->findModel());
        
        if($model->load(Yii::$app->request->post()) && $model->changePassword())
        {
            return $this->redirect(['user']);
        } else {
            return $this->render('changePassword', [
                'model' => $model,
            ]);
        }
    }
    
    public function findModel()
    {
        return User::findOne(Yii::$app->user->identity->getId());
    }
}