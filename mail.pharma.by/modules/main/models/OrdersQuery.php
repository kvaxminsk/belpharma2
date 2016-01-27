<?php

namespace app\modules\main\models;

/**
 * This is the ActiveQuery class for [[Orders]].
 *
 * @see Orders
 */
class OrdersQuery extends \yii\db\ActiveQuery
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
    
    /**
     * Получает общую сумму заказа
     * @return integer сумма в рублях
     */
    public static function totalPrice()
    {
        $orderedProducts = OrderedProduct::find()->allProducts();
        return self::calcTotalPrice($orderedProducts);
    }
    
    /**
     * Получает общую сумму заказа по его id
     * @param type $id - идентификатор заказа
     * @return integer сумма в рублях
     */
    public static function totalPriceThis($id)
    {
        $orderedProducts = OrderedProduct::find()->allProductsForOrder($id);
        return self::calcTotalPrice($orderedProducts);
    }
    
    /**
     * Получает общую сумму заказа по его ID
     * @param integer ID заказа
     * @return integer сумма в рублях
     */
    public static function totalPriceForOrder($orderId)
    {
        $orderedProducts = OrderedProduct::find()->allProductsForOrder($orderId);
        return self::calcTotalPrice($orderedProducts);
    }
    
    /**
     * Высчитывает сумму. Складывает оптовую цену по всем товарам с учетом их количества
     * в заказе.
     * @param OrderedProduct $orderedProducts
     * @return integer
     */
    protected static function calcTotalPrice($orderedProducts)
    {
        $totalPrice = 0;
        foreach ($orderedProducts as $product) 
        {
            $totalPrice += $product->wholesaleTotalPrice;
        }
        return $totalPrice;
    }
}