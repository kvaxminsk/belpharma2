<?php

namespace app\modules\main\controllers;

use Yii;
use app\modules\main\models\Orders;
use app\modules\main\models\OrdersQuery;
use app\modules\main\models\OrdersSearch;
use app\modules\main\models\OrderedProduct;
use app\modules\main\models\OrderedProductSearch;
use app\modules\main\models\Countries;
use app\modules\user\models\User;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'status-confirm' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['index', 'history', 'get-counters', 'list-by-agent',
                            'status-confirm', 'create-order', 'view', 'create', 'update',
                            'repeat'],
                    ],
                ]
            ],
        ];
    }
    
    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }
    
    public function actionHistory()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->searchHistory(Yii::$app->request->queryParams);
        $model = new Orders();
        
        if($model->load(Yii::$app->request->post())) {
            if(!$model->hasErrors('updated_at')) {
                Yii::$app->session->setFlash('success','Заявки за выбранный период времени удалены');
                Orders::deleteAll(['and', ['user_id' => Yii::$app->user->getId()], ['between', 'updated_at', '2015-09-09 00:00:00', $model->updated_at]]);
                return $this->refresh();
            } else {
                Yii::$app->session->set('error', 'Ошибка в дате');
                return $this->refresh();
            }
        }
        
        return $this->render('history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
    
    public function actionListByAgent($id)
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->searchListByAgent(Yii::$app->request->queryParams, $id);
        $user = User::findOne($id);
        return $this->render('listByAgent', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user' => $user,
        ]);
    }
    
    public function actionStatusConfirm($id)
    {
        $model = $this->findModel($id);
        $model->status = Orders::STATUS_SENDED;
        $model->save();
        Yii::$app->session->setFlash('success', 'Заказ №' . $model->id . ' - подтвержден.');
        return $this->redirect(['list-by-agent', 'id' => $model->user_id]);
    }
    
    public function actionCreateOrder() 
    {
        $session = Yii::$app->session;
        $session->set('creatingOrder', true);
        $order = Orders::createInstanceByAgent();
        $order->save();
        $session->set('idOrder', $order->id);
        $session->set('countOrderedProducts', 0);
        Yii::$app->session->setFlash('success', 'Заказ не содержит в себе ни одного товара. Выбирите товары и прикрепите к заказу');
        return $this->redirect('/main/products');
    }

    /**
     * Displays a single Orders model.
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
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orders();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Orders model.
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
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionGetCounters()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $totalPrice = Orders::getPriceOfOrder();
        $orderedProducts = OrderedProduct::find()->countOrdered();
        return [
            'totalPrice' => $totalPrice,
            'orderedProducts' => $orderedProducts,
        ];
    }
    
    public function actionRepeat($id)
    {
        $orderId = $id;
        $totalPrice = OrdersQuery::totalPriceThis($id);
        $order = Orders::findOne($orderId);
        $searchModel = new OrderedProductSearch();
        $dataProvider = $searchModel->searchAttachToTheOrder($id, Yii::$app->request->queryParams);
        $validOrder = true;
        $orderedProducts = $dataProvider->models;
        foreach($orderedProducts as $orderdedProduct) {
            if(!$orderdedProduct->isProduct) {
                $validOrder = false;
            }
        }
        if($dataProvider->count < $dataProvider->totalCount) {
            $validOrder = false;
        }
        return $this->render('repeat', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalPrice' => $totalPrice,
            'order' => $order,
            'validOrder' => $validOrder,
        ]);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function isAdmin()
    {
        if(Yii::$app->user->identity->role == 1)
        {
            return true;
        } else {
            \yii\web\HttpException(404);
        }
    }
}
