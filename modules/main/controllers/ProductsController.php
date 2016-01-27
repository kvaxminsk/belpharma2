<?php

namespace app\modules\main\controllers;

use Yii;
use app\modules\main\models\Products;
use app\modules\main\models\ProductsSearch;
use app\modules\main\models\OrderedProduct;
use app\modules\main\models\Countries;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'desc-view' => ['post'],
                    'desc-view-ordered' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'view', 'delete', 
                            'desc-view', 'desc-view-ordered'],
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $countries = Countries::find()->all();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'countries' => $countries,
        ]);
    }

    /**
     * Displays a single Products model.
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
     * Возвращает JS-объект с подробной информацией о товаре по ид модели Products
     * @param integer $id
     * @return json
     */
    public function actionDescView($id)
    {
        $model = $this->findModel($id);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $model->attributes;
    }
    
    /**
     * Возвращает JS-объект с подробной информацией о товаре по ид модели OrderedProduct
     * @param integer $id
     * @return js-object|json|string
     */
    public function actionDescViewOrdered($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $ordered = OrderedProduct::findOne($id);
        $kpr = $ordered->kpr;
        $namepr = $ordered->dsv;//Имя производителя в модели Products и OrderedProduct
        $model = Products::findOne(['kpr' => $kpr, 'namepr' => $namepr]);
        if(!empty($model)) {
            return $model->attributes;
        } else {
            return 'empty';
        }
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->validateIsAdmin();
        $model = new Products();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->validateIsAdmin();
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
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->validateIsAdmin();
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function validateIsAdmin()
    {
        if(Yii::$app->user->identity->role != 1)
        {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }   
}
