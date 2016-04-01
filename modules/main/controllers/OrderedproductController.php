<?php

namespace app\modules\main\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use app\components\events\OrderEvent;
use app\modules\main\models\Products;
use app\modules\main\models\OrderedProduct;
use app\modules\main\models\OrderedProductSearch;
use app\modules\main\models\Orders;
use app\modules\main\models\OrdersQuery;


/**
 * OrderedproductController implements the CRUD actions for OrderedProduct model.
 */
class OrderedproductController extends Controller
{
    const EVENT_ADD_PRODUCT_TO_ORDER = 'addProductToOrder';
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'remove' => ['post'],
                    'send-order' => ['post'],
                    'send-order-from-history-page' => ['post'],
                ],
            ],
        ];
    }

    public function actionAdd($id)
    {
        $product = Products::findOne(['kodpart' => $id]);
        $model = new OrderedProduct();
        $model->kodpart = $product->kodpart;
        $model->kpr = $product->kpr;
        $model->imn = $product->tn;
        $model->otd = $product->otd;
        $model->dsv = $product->namepr;
        $model->user_id = Yii::$app->user->getId();
        $model->buggod = true;
        $event = new OrderEvent();
        $event->orderedProduct = $model;
        $model->on(self::EVENT_ADD_PRODUCT_TO_ORDER, ['app\modules\main\models\Orders', 'createNewOrder']);

        if ($model->load(Yii::$app->request->post())) {
            $model->trigger(self::EVENT_ADD_PRODUCT_TO_ORDER, $event);
            if($model->save())
            {
                Yii::$app->session->setFlash('success', 'Товар с кодом: ' . $model->kodpart . ' успешно прикреплен к заявке. Просмотреть список товаров в заявке можно по следующей' . Html::a('', ''));
            
                return $this->redirect(['/main/products']);
            }
        } else {
            return $this->render('add', [
                'model' => $model,
                'product' => $product,
            ]);
        }
    }
    
    /**
     * добавить продукт
     * @param type $id - код лр
     * @return string
     */
    public function actionAddToProduct($id)
    {
        $product = Products::findOne(['kodpart' => $id]);
        $model = OrderedProduct::findOne([
            'kodpart' => $id,
            'user_id' => Yii::$app->user->getId(), 
            'order_id' => Yii::$app->session->get('idOrder')
            ]);
        if(empty($model)) {
            $model = new OrderedProduct();
            $model->kodpart = $product->kodpart;
            $model->kpr = $product->kpr;
            $model->imn = $product->tn;
            $model->otd = $product->otd;
            $model->dsv = $product->namepr;
            $model->user_id = Yii::$app->user->getId();
            $model->buggod = true;
        }
        $event = new OrderEvent();
        $event->orderedProduct = $model;
        $model->on(self::EVENT_ADD_PRODUCT_TO_ORDER, ['app\modules\main\models\Orders', 'createNewOrder']);

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model->kolz = (int)$post['kol'];
            $model->trigger(self::EVENT_ADD_PRODUCT_TO_ORDER, $event);
            if($model->save())
            {
                return $model->kolz;
            }
        } else {
            return 'false';
        }
    }
    
    /**
     * добавить продукт к заказу
     * @param type $id - код лр
     * @param type $orderId - ид заказа
     * @return string
     */
    public function actionAddToProductForOrder($id, $orderId)
    {
        $product = Products::findOne(['kodpart' => $id]);
        $model = OrderedProduct::findOne([
            'kodpart' => $id,
            'user_id' => Yii::$app->user->getId(), 
            'order_id' => $orderId,
            ]);
        if(empty($model)) {
            $model = new OrderedProduct();
            $model->kodpart = $product->kodpart;
            $model->imn = $product->tn;
            $model->otd = $product->otd;
            $model->dsv = $product->namepr;
            $model->user_id = Yii::$app->user->getId();
            $model->buggod = true;
        }
        
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model->kolz = (int)$post['kol'];
            if($model->save())
            {
                return $model->kolz;
            }
        } else {
            return 'false';
        }
    }
    
    /**
     * Первый этап оформления заказа. Список товаров прикрепленных к заказу.
     * @return mixed
     */
    public function actionCheckout()
    {
        $totalPrice = OrdersQuery::totalPrice();
        $order = Orders::findOne(Yii::$app->session->get('idOrder'));
        $searchModel = new OrderedProductSearch();
        $dataProvider = $searchModel->searchAttachToOrder(Yii::$app->request->queryParams);
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
        if(isset($order) && $order->load(Yii::$app->request->post()) && $order->save()) {
            $this->redirect(['confirm-checkout']);
        } else {
            return $this->render('checkout', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'totalPrice' => $totalPrice,
                'order' => $order,
                'validOrder' => $validOrder,
            ]);
        }
    }
    
    /**
     * Активизирует заказ из истории как оформляемый(добавляется в сессию инфомрация о нем)
     * @param integer $id ИД заказа из модели OrderedProduct
     * @return mixed
     */
    public function actionCheckoutOther($id)
    {
        $model = Orders::findOne($id);
        if(empty($model) || $model->user_id != Yii::$app->user->getId())
            throw new \yii\web\HttpException(404);
        $session = Yii::$app->session;
        $session->set('creatingOrder', 1);
        $session->set('idOrder', $model->id);
        $count = OrderedProduct::find()->countProductsForOrder($model->id);
        $session->set('countOrderedProducts', $count);
        $mess = 'Заказ №' . $model->id .' из истории активизирован как оформляемый.<br>'
                . 'Сейчас заказ содержит ' . $count . ' товаров.<br>';
        $session->setFlash('success', $mess);
        return $this->redirect(['/main/products']);
    }
    
    /**
     * Второй этап оформления заказа. Проверка и подтверждение отправки.
     * @return mixed
     */
    public function actionConfirmCheckout()
    {
        $orderId = Yii::$app->session->get('idOrder');
        $totalPrice = OrdersQuery::totalPrice();
        $order = Orders::findOne($orderId);
        $searchModel = new OrderedProductSearch();
        $dataProvider = $searchModel->searchAttachToOrder(Yii::$app->request->queryParams);
        return $this->render('confirmCheckout', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalPrice' => $totalPrice,
            'buggod' => $order->buggodName,
        ]);
    }
    
    /**
     * Изменение содержимого существующего заказа через историю.
     * @param integer $id ИД заказа
     * @return type
     */
    public function actionChange($id)
    {
        $totalPrice = OrdersQuery::totalPriceThis($id);
        $order = Orders::findOne($id);
        $searchModel = new OrderedProductSearch();
        $dataProvider = $searchModel->searchAttachToTheOrder($id, Yii::$app->request->queryParams);
        if(isset($order) && $order->load(Yii::$app->request->post()) && $order->save()) {
            $this->redirect(['/main/orders/repeat', 'id' => $id]);
        } else {
            return $this->render('change', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'totalPrice' => $totalPrice,
                'order' => $order,
            ]);
        }
    }
    
    public function actionRemove($id)
    {
        Orders::findOne($id)->delete();
        Yii::$app->session->setFlash('success', 'Заказ удален из истории');
        return $this->redirect(['/main/orders/history']);
    }
    
    /**
     * Получает список товаров в одном из заказов контрагента
     * @param intger $id - это ид заказа
     * @return type
     */
    public function actionConfirmCheckoutByAdmin($id)
    {
        $totalPrice = OrdersQuery::totalPriceForOrder($id);
        $order = Orders::findOne($id);
        $searchModel = new OrderedProductSearch();
        $dataProvider = $searchModel->searchAttachToOrderWithId(Yii::$app->request->queryParams, $id);
        return $this->render('confirmCheckoutByAdmin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalPrice' => $totalPrice,
            'order' => $order,
        ]);
    }
    
    /**
     * Отправка заказа со страницы "Оформить заказ" (изменяет переменные сессии)
     * @param type $id - ИД заказа
     */
    public function actionSendOrder($id)
    {
        $session = Yii::$app->session;
        $order = Orders::findOne(['id' => $id]);
        $order->status = Orders::STATUS_SENDED;
        $order->save();
        $order->createDbf();
        $session->set('creatingOrder', false);
        $session->set('idOrder', 0);
        $session->setFlash('success', 'Заказ отправлен');
        $this->redirect(['/main/orders/history']);
    }
    
    /**
     * Отправка заказа из истории (с проверкой на изменение переменных сессии)
     * @param type $id - ИД заказа
     */
    public function actionSendOrderFromHistoryPage($id) 
    {
        $session = Yii::$app->session;
        $order = Orders::findOne(['id' => $id]);
        
        if($session->get('idOrder') == $id) {
            $order->status = Orders::STATUS_SENDED;
            $session->set('creatingOrder', false);
            $session->set('idOrder', 0);
        } else if($order->status == Orders::STATUS_SENDED) {
            $countRepeat = $order->count_repeat;
            $order->count_repeat = $countRepeat + 1;
        } else {
            $order->status = Orders::STATUS_SENDED;
        }
        
        $order->save();
        $order->createDbf();
        $session->setFlash('success', 'Заказ отправлен');
        $this->redirect(['/main/orders/history']);
    }
    
    /*public function actionS()
    {
        Yii::$app->session->set('creatingOrder', false);
        echo 'Key "creatingOrder" update to FALSE';
    } */  
    
    /**
     * Lists all OrderedProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        
    }

    /**
     * Displays a single OrderedProduct model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->updateCountOrderedProducts();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new OrderedProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     *
    public function actionCreate()
    {
        $model = new OrderedProduct();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Updates an existing OrderedProduct model.
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
     * Deletes an existing OrderedProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['checkout']);
    }
    
    public function actionGetAttachedToOrder()
    {
        $products = OrderedProduct::find()->allProducts();
        $response = array();
        foreach ($products as $product) {
            $response [] = [
                'kodpart' => $product->kodpart,
                'kolz' => $product->kolz,
            ];
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $response;
    }
    
    public function actionGetAttachedToTheOrder($id)
    {
        $products = OrderedProduct::find()->where(['order_id' => $id])->all();
        $response = array();
        foreach ($products as $product) {
            $response [] = [
                'kodpart' => $product->kodpart,
                'kolz' => $product->kolz,
            ];
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $response;
    }
    
    protected function updateCountOrderedProducts()
    {
        $count = OrderedProduct::find()->countOrdered();
        Yii::$app->session->set('countOrderedProducts', $count);
    }

    /**
     * Finds the OrderedProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderedProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderedProduct::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
