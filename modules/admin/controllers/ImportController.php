<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\ImportProducts;
use app\modules\admin\models\ImportProductsSearch;
use app\modules\user\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ImportController implements the CRUD actions for ImportProducts model.
 */
class ImportController extends Controller
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
     * Lists all ImportProducts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImportProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ImportProducts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ImportProducts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ImportProducts();

        if ($model->load(Yii::$app->request->post())) {
            $dirStorage = Yii::getAlias('@webroot') . '/import/';
            $file = UploadedFile::getInstance($model, 'filename');
            
            if(isset($file) && $file != "") {
                $model->filename = $model->uploadXml($file, $dirStorage);
                $model->save();
            }
            
            $report = $model->transferXmlToDb();
            $model->countXml = $report['countXml'];
            $model->countDb = $report['countDb'];
            $reportString = 'Количество товаров в xml: ' . $report['countXml'] . '<br>';
            $reportString .= 'Количество товаров импортированных в приложение: ' . $report['countDb'] . '<br>';
            if(!empty($report['notImport'])) {
                $reportString .= '<b>Список не импортированных товаров:</b><br>';
                $list = '';
                foreach ($report['notImport'] as $product) {
                    $reportString .= $product . '<br>';
                    $list .= $product . '<br>';
                }
                $model->notImport = $list;
            } else {
                $reportString .= '<b>Все товары импортированы в приложение<b>';
            }
            $model->save();
            Yii::$app->session->setFlash('success', 'XML-файл успешно импортирован. Данные в БД-приложения заменены.<br>' . $reportString );
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionReport($id) {
        $model = $this->findModel($id);
        $user = User::findOne(['id' => $model->user_id]);
        return $this->render('report', [
            'model' => $model,
            'user' => $user,
        ]);
    }

    /**
     * Updates an existing ImportProducts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ImportProducts model.
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
     * Finds the ImportProducts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ImportProducts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ImportProducts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
