<?php

namespace app\modules\main\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use app\modules\user\models\User;
use app\modules\main\models\OrderedProduct;
use app\modules\main\models\OrderedProductQuery;
use app\modules\admin\models\Settings;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $user_id
 * @property string $created_at
 * @property integer $repeated
 */
class Orders extends \yii\db\ActiveRecord
{
    const STATUS_NOT_SENDED = 0;
    const STATUS_SENDED = 1;
    
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new \yii\db\Expression('NOW()'),
            ]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['status', 'user_id', 'created_at', 'repeated'], 'required'],
            [['status', 'user_id', 'changed', 'buggod', 'count_repeat', 'repeated'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID заказа',
            'status' => 'Статус заказа',
            'user_id' => 'ИН контрагента в веб-приложении',
            'created_at' => 'Дата и время создания',
            'updated_at' => 'Дата',
            'changed' => 'Признак измененности заказа',
            'repeated' => 'Признак повторной отправки',
            'buggod' => 'Бюджетный', 
            'count_repeat' => 'Количество повторных заказов'
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusArray(), $this->status);
    }
    
    public function getBuggodName()
    {
        return ArrayHelper::getValue($this->buggodArray, $this->buggod);
    }
    
    public function getBuggodArray()
    {
        return [
            0 => 'Внебюджетный', 
            1 => 'Бюджетный',
        ];
    }
    
    public function getTotalPriceForOrder()
    {
        return number_format(self::find()->totalPriceForOrder($this->id), 0, ',', ' ');
    }
    
    public function getCountProducts()
    {
        return OrderedProduct::find()->countProductsForOrder($this->id);
    }
    
    public static function getStatusArray()
    {
        return [
            self::STATUS_NOT_SENDED => 'Заказ не оптправлен',
            self::STATUS_SENDED => 'Заказ отправлен',
        ];
    }
    
    /**
     * @inheritdoc
     * @return OrdersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrdersQuery(get_called_class());
    }
    
    /**
     * Создание и генерация файлов заказов по отделам в формате dbf c последующей отправкой их на сервер ftp.
     */
    public function createDbf()
    {
        $localFolder = Yii::getAlias('@webroot') . '/export/';
        $orderedProducts = OrderedProduct::findAll(['order_id' => $this->id]);
        $contragentCod = User::findOne($this->user_id)->cod;
        //Structure of the dbf-file
        $def = array(
            array('KPR', 'C', 7, 0),
            array('IMN', 'C', 120, 0),
            array('OTD', 'N', 2, 0),
            array('KOLZ', 'N', 10, 3),
            array('DSV', 'C', 80, 0),
            array('BUDDOG', 'L')
        );
        /** 
         * Наполенние массива номерами складов и названиями файлов под них
         * $key - это номер отдела $order->otd.
         * $value - это имя файла, который нужно сгенерировать.
         */
        $otds = array();
        foreach ($orderedProducts as $product) {
            $isRepeat = false;
            foreach($otds as $key => $value) {
                if($key == $product->otd) {
                    $isRepeat = true;
                }
            }
            if($isRepeat==false) {
                $otds[$product->otd] = $this->generateFileName($product->otd, $this->id, $contragentCod);
            }
        }
        if(empty($otds)) {
            return false;
        }
        foreach ($otds as $otd => $filename) {
            $dbf = dbase_create($localFolder.$filename, $def);
            foreach ($orderedProducts as $product) {
                if($product->otd == $otd) {
                    if($this->buggod) {
                        $buggod = "T";
                    } else {
                        $buggod = "F";
                    }
                    $fromEncoding = "UTF-8";
                    $toEncoding = "CP866";
                    $imn = iconv($fromEncoding, $toEncoding, $product->imn);
                    $dsv = iconv($fromEncoding, $toEncoding, $product->dsv);
                    $record = array($product->kpr, $imn, $product->otd, $product->kolz, $dsv, $buggod);
                    dbase_add_record($dbf, $record);
                }
            }
            dbase_close($dbf);
            $this->sendToFtpServer($filename, $localFolder.$filename);
        }
        return true;
    }
    
    protected function generateFileName($otd, $orderId, $contragentCod)
    {
        $format = 'AG_%02d%03d.%03d';
        $filename = sprintf($format, $otd, $orderId, $contragentCod);
        return $filename;        
    }

    /**
     * Разрабатывалась по ошибке(создавать нужно не в xml формате, а в dbf), $order - и есть экземляр этого класса.
     * @param type $order
     */
    public function createXml($order)
    {
        $orderedProducts = OrderedProduct::findAll(['order_id' => $order->id]);
        
        $dom = new \DOMDocument("1.0", "utf-8");
        $root = $dom->createElement('Корневой');
        $dom->appendChild($root);
        foreach ($orderedProducts as $product) {
            $row = $dom->createElement('ROW');
            $kpr = $dom->createElement('KPR', $product->kpr);
            $imn = $dom->createElement('IMN', $product->imn);
            $otd = $dom->createElement('OTD', $product->otd);
            $kolz = $dom->createElement('KOLZ', $product->kolz);
            $dsv = $dom->createElement('DSV', $product->dsv);
            $buddog = $dom->createElement('BUGGOD', $order->buggod);
            $row->appendChild($kpr);
            $row->appendChild($imn);
            $row->appendChild($otd);
            $row->appendChild($kolz);
            $row->appendChild($dsv);
            $row->appendChild($buddog);
            $root->appendChild($row);
        }
        $localFilename = Yii::getAlias('@webroot') . '/export/'."AG_00" . "00$order->id" . "." . Yii::$app->user->identity->cod . ".xml";
        $remoteFilename = "AG_00" . "00$order->id" . "." . Yii::$app->user->identity->cod . ".DMF";
        $dom->save($localFilename);
        $this->sendToFtpServer($remoteFilename, $localFilename);
    }
    
    protected function sendToFtpServer($remoteFilename, $localFilename)
    {
        //$host='mail.pharma.by';
        $host=  Settings::findOne(['key' => 'ftp-host'])->value;
        $login=Settings::findOne(['key' => 'ftp-login'])->value;
        $password=Settings::findOne(['key' => 'ftp-password'])->value;
        $remoteFolder = Settings::findOne(['key' => 'ftp-folder-in'])->value . '/';
        
        //$host='ru111.atservers.net';
        //$login='arusnavi';
        //$password='arusnaviGhbdtn';
        
        $ftp_stream = ftp_connect($host);
        if(ftp_login($ftp_stream, $login, $password)) {
            ftp_put($ftp_stream, $remoteFolder.$remoteFilename, $localFilename, FTP_BINARY);
        }
    }
    
    public static function createNewOrder($event)
    {
        $session = Yii::$app->session;
        if(Yii::$app->session->get('creatingOrder') == 1)
        {
            $event->orderedProduct->order_id = $session->get('idOrder');
            $session->set('countOrderedProducts', OrderedProduct::find()->countOrdered()+1);
        } else {
            $order = self::createInstanceByAgent();
            if($order->save())
            {
                $session->set('creatingOrder', 1);
                $session->set('idOrder', $order->id);
                $session->set('countOrderedProducts', 1);
                $event->orderedProduct->order_id = $order->id;
            }
        }
    }
    
    public static function createInstanceByAgent()
    {
        $order = new Orders();
        $order->status = self::STATUS_NOT_SENDED;
        $order->user_id = Yii::$app->user->identity->id;
        $order->changed = 0;
        $order->repeated = 0;
        $order->count_repeat = 0;
        $order->buggod = 1;
        return $order;
    }
    
    public static function getPriceOfOrder()
    {
        $priceOfOrder = self::find()->totalPriceForOrder(Yii::$app->session->get('idOrder'));
        return number_format($priceOfOrder, 0, ',', ' ');
    }
}