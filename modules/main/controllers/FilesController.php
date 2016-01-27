<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\main\controllers;

use Yii;
use yii\web\Controller;
use app\modules\admin\models\Settings;
use app\modules\main\models\Invoices;
use app\modules\main\models\Zips;

/**
 * Description of FilesController
 *
 * @author mr
 */
class FilesController extends Controller 
{
    public function actionIndex()
    {
        $host= Settings::findOne(['key' => 'ftp-host'])->value;
        $login=Settings::findOne(['key' => 'ftp-login'])->value;
        $password=Settings::findOne(['key' => 'ftp-password'])->value;
        $folder = Settings::findOne(['key' => 'ftp-folder-out'])->value;
        $codUser = Yii::$app->user->identity->cod;
        $files = array();
        $ftpStream = ftp_connect($host);
        
        if($ftpStream != false && ftp_login($ftpStream, $login, $password)) {
            $buf = ftp_rawlist($ftpStream, $folder);
            foreach ($buf as $item) {
                $length = strlen($item);
                $startPosition = $length-12;
                $fullFilename = substr($item, $startPosition);
                $partsFilename = explode('.', $fullFilename);
                isset($partsFilename[1]) ? $cod = $partsFilename[1] : $cod = 77777;//fix parse filenames
                if($cod == $codUser) {
                    $files [] = $fullFilename;
                }
            }
        }
        
        return $this->render('index', [
            'files' => $files,
        ]);
    }
    
    public function actionGenerateInvoices() {
        $host= Settings::findOne(['key' => 'ftp-host'])->value;
        $login=Settings::findOne(['key' => 'ftp-login'])->value;
        $password=Settings::findOne(['key' => 'ftp-password'])->value;
        $folder = Settings::findOne(['key' => 'ftp-folder-out'])->value;
        $codUser = Yii::$app->user->identity->cod;
        $files = array();
        $ftpStream = ftp_connect($host);
        
        if($ftpStream != false && ftp_login($ftpStream, $login, $password)) {
            $buf = ftp_rawlist($ftpStream, $folder);
            foreach ($buf as $item) {
                $length = strlen($item);
                $startPosition = $length-12;
                $fullFilename = substr($item, $startPosition);
                $partsFilename = explode('.', $fullFilename);
                isset($partsFilename[1]) ? $cod = $partsFilename[1] : $cod = 77777; //fix parse filenames
                if($cod == $codUser) {
                    $files [] = $fullFilename;
                    $invoice = new Invoices();
                    $invoice->cod = $partsFilename[1];
                    $invoice->number = $partsFilename[0];
                    $invoice->save();
                }
            }
        }
        if(empty($files)) {
            Yii::$app->session->setFlash('error', 'Файлов с накладными на ftp-сервере для Вас не существует!');
            return $this->redirect(['error-log']);
        }
        $date = date('D_d_M_Y_H_i_s');
        $filenameZip = 'invoice_for_user_' . Yii::$app->user->identity->cod . '---created_date_' . $date . '.zip'; 
        //Configuration info:
        $invoicesFolder = 'invoices/';
        $zipFolder = 'zips/';
        $remoteFolder = 'out/';
        //Status information for end user:
        $statusesFtpGet = array();
        $statusesZipArchive = array();
        //Create zip-file for write to it of the invoices files
        $zip = new \ZipArchive();        
        if($zip->open($zipFolder.$filenameZip, \ZipArchive::CREATE) !== true) {
            Yii::$app->session->setFlash('error', 'Zip-архив с накладными не создан! Обратитесь к администратору сервера или разработчику.');
            return $this->redirect(['error-log']);
        }
        //Copy invoice files to the server
        foreach ($files as $file) {$statusesFtpGet [] = ftp_get($ftpStream, $invoicesFolder.$file, $remoteFolder.$file, FTP_BINARY);
            if(end($statusesFtpGet)) {
                //Add invoice file to the creating archive
                $statusesZipArchive[] = $zip->addFile($invoicesFolder.$file);
            }
        }
        $zipInfo = array();
        $zipInfo['status'] = $zip->status;
        $zipInfo['numfiles'] = $zip->numFiles;
        $zip->close();
        
        return $this->render('generateInvoices', [
            'zipInfo' => $zipInfo,
            'statusesFtpGet' => $statusesFtpGet,
            'statusesZipArchive' => $statusesZipArchive,
            'files' => $files,
            'filenameZip' => $filenameZip,
            'zipFolder' => $zipFolder,
        ]);
    }
    
    public function actionErrorLog()
    {
        return $this->render('errorLog');
    }
    
    public function actionGeneratedZips()
    {
        $models = $this->findZips();
        return $this->render('zips', [
            'models' => $models,
        ]);
    }
    
    protected function findZips()
    {
        if(($model = Zips::findAll(['contragent_cod' => Yii::$app->user->identity->cod])) !== null) {
            return $model;
        } else {
            throw new \yii\web\HttpException('Страница не существует. Обратитесь к администратору сервера или к разработчику для выяснения проблемы');
        }
    }
}
