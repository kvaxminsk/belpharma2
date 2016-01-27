<?php

namespace app\modules\main\models;

use Yii;

/**
 * This is the ActiveQuery class for [[Orders]].
 *
 * @see Orders
 */
class OrderedProductQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Orders[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Orders|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
    public function whereOrderId()
    {
        $orderId = Yii::$app->session->get('idOrder');
        return parent::where(['order_id' => $orderId]);
    }
    
    /**
     * Возвращает все продукты в текущем оформляемом заказе контрагентом
     * @return OrderedProducts все модели продуктов в заказе
     */
    public function allProducts()
    {
        return $this->whereOrderId()->all();
    }
    
    /**
     * Возвращает все продукты в заказе по его ид
     * @param integer ID заказа
     * @return OrderedProducts все модели продуктов в заказе
     */
    public function allProductsForOrder($id)
    {
        return parent::where(['order_id' => $id])->all();
    }
    
    public function countOrdered()
    {
        return $this->whereOrderId()->count();
    }
    
    public function countProductsForOrder($id)
    {
        return parent::where(['order_id' => $id])->count();
    }
}