<?php

namespace app\modules\main\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\main\models\Products;

/**
 * This is the model class for table "ordered_product".
 *
 * @property integer $id

 * @property string $imn
 * @property string $otd
 * @property string $kolz
 * @property string $dsv
 * @property integer $buggod
 * @property integer $status
 * @property integer $order_id
 * @property integer $user_id
 * @property integer $kodpart
 * @property integer $kpr
 */
class OrderedProduct extends \yii\db\ActiveRecord
{
    //Возможные статусы заказанного товара:
    /**
     * Статусы: Перед заказом, ожидает подтверждения админом, одобрен админом.
     * !!!СТАТУСЫ ИСПОЛЬЗУЮТСЯ В МОДЕЛИ ORDER!!!
     */
    const STATUS_PRE_ORDERED = 0;
    const STATUS_WAIT_ORDERED = 1;
    const STATUS_ORDERED = 2;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ordered_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['kpr', 'imn', 'otd', 'kolz', 'dsv', 'buggod', 'status'], 'required'],
            [['buggod', 'status', 'user_id', 'order_id', 'otd'], 'integer'],
            [['kolz'],'string', 'max' => 5],
            [['kpr'], 'string', 'max' => 7],
            [['kodpart'], 'string', 'max' => 7],
            [['imn', 'dsv'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
//            'kpr' => 'Код лекарственного средства',
            'imn' => 'Наименование лекарственного средства',
            'otd' => 'Отдел склада',
            'kolz' => 'Заказанное количество',
            'dsv' => 'Производитель',
            'buggod' => 'Бюджетный',
            'status' => 'Статус',
            'user_id' => 'ID контрагента в приложении',
            'order_id' => 'Номер заказа',
            'kodpart' => 'Код партии товара',
            //'product_id' => 'Номер товара в БД веб-приложения',
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusArray(), $this->status);
    }
    
    /**
     * Получает оптовую цену за одну штуку товара
     * @return integer цена в рублях
     */
    public function getWholesalePrice()
    {
        $price = Products::findOne(['kodpart' => $this->kodpart, 'otd' => $this->otd, 'namepr' => $this->dsv]);
        if(isset($price)) {
            return $price->cenopt+$price->nds*$price->cenopt/100;
        } else {
            return null;
        }
        
    }

    /**
     * Получить суммарную оптовую цену по заказанному товару
     * @return integer цена в рублях
     */
    public function getWholesaleTotalPrice()
    {
        $price = $this->getWholesalePrice();
        $totalPrice = $price * $this->kolz;
        return $totalPrice;
    }
    
    /**
     * Существует ли товар на складе?
     * @return boolean
     */
    public function getIsProduct()
    {
        $condition = ['kodpart' => $this->kodpart, 'otd' => $this->otd, 'namepr' => $this->dsv];
        $productModel = Products::findOne($condition);
        if(!empty($productModel)) { 
            return true; 
        } else { 
            return false;
        }
    }
    
    public static function getStatusArray()
    {
        return [
            self::STATUS_PRE_ORDERED => 'Предварительный заказаз товара',
            self::STATUS_WAIT_ORDERED => 'Заказ отправлен контрагентом',
            self::STATUS_ORDERED => 'Заказ одобрен администратором',
        ];
    }
    /**
     * @inheritdoc
     * @return OrdersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderedProductQuery(get_called_class());
    }
}