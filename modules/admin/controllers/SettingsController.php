<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Settings;

class SettingsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $ftpHost = Settings::findOne(['key' => 'ftp-host']);
        $ftpLogin = Settings::findOne(['key' => 'ftp-login']);
        $ftpPassword = Settings::findOne(['key' => 'ftp-password']);
        $ftpIn = Settings::findOne(['key' => 'ftp-folder-in']);
        $ftpOut = Settings::findOne(['key' => 'ftp-folder-out']);
        
        return $this->render('index',[
            'ftpHost' => $ftpHost,
            'ftpLogin' => $ftpLogin,
            'ftpPassword' => $ftpPassword,
            'ftpIn' => $ftpIn,
            'ftpOut' => $ftpOut,
        ]);
    }
    public function actionSave($key)
    {
        $session =  Yii::$app->session;
        $setting = Settings::findOne(['key' => $key]);
        if($setting->load(Yii::$app->request->post()) && $setting->save())
        {
            $session->setFlash('success', 'Данные успешно сохранены!');
            return $this->redirect(['index']);
        } else {
            $session->setFlash('error', 'Ошибка при сохранении. Попробуйте позже. В случае повторного возникновения этой ошибки обратитесь к администратору сервера или разработчику системы.');
            return $this->redirect(['index']);
        }
    }
}
