<?php

namespace app\modules\main\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $mnn
 * @property string $tn
 * @property string $kpr
 * @property string $nshort3
 * @property string $namepr
 * @property string $country
 * @property integer $otd
 * @property integer $osnls
 * @property integer $tender
 * @property string $spar
 * @property string $goden_do
 * @property double $cenopt
 * @property double $cenrozn
 * @property double $kol
 * @property string $tendergod
 * @property string $vidtovara
 * @property integer $obnalichie
 * @property integer $kolotgr
 * @property string $vidpost
 * @property string $kodpart
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['mnn', 'tn', 'kpr', 'namepr', 'country', 'otd', 'osnls', 'tender', 'spar', 'goden_do', 'cenopt', 'cenrozn', 'kol', 'tendergod', 'vidtovara', 'obnalichie', 'vidpost'], 'required'],
            [['otd', ], 'integer'],
            [['osnls', 'tender', 'obnalichie'], 'boolean'],
            [['goden_do'], 'safe'],
            [['cenopt', 'cenrozn', 'kol', 'kolotgr'], 'number'],
            [['mnn', 'tn', 'nshort3', 'namepr'], 'string', 'max' => 150],
            [['kpr'], 'string', 'max' => 7],
            [['country'], 'string', 'max' => 50],
            [['spar'], 'string', 'max' => 40],
            [['tendergod'], 'string', 'max' => 5],
            [['vidtovara', 'vidpost'], 'string', 'max' => 255],
            [['kodpart'], 'string', 'max' => 7],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mnn' => 'Международное наименование',
            'tn' => 'Торговое наименование',
            'kpr' => 'Код лекарственного средства',
            'nshort3' => 'Форма выпуска',
            'namepr' => 'Наименование производителя',
            'country' => 'Страна производства',
            'otd' => 'Отдел склада',
            'osnls' => 'Признак основного ЛС',
            'tender' => 'Признак централизованного тендера',
            'spar' => 'Серия партии',
            'goden_do' => 'Срок годности',
            'cenopt' => 'Цена оптовая',
            'cenrozn' => 'Цена розничная',
            'kol' => 'Количество на складе',
            'tendergod' => 'Год централизованного тендера',
            'vidtovara' => 'Вид товара',
            'obnalichie' => 'Признак обязательного наличия в аптеке',
            'kolotgr' => 'Количество в заводской упаковке',
            'vidpost' => 'Вид поступления',
            'kodpart' => '',
        ];
    }

    public function getOsnlsName()
    {
        return $this->osnls == true ? 'ОС' : '-';
    }
    
    public function getTenderName()
    {
        return $this->tender == true ? 'ЦТ' : '-';
    }
    
    public function getObnalichieName()
    {
        return $this->osnls == true ? 'Обязательно' : '-';
    }
    
    /**
     * @inheritdoc
     * @return ProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductsQuery(get_called_class());
    }
    
    public static function getOsnlsArray()
    {
        return [
            1 => 'ОС',
            0 => ' - ',
        ];
    }
    
    public static function getTenderArray()
    {
        return [
            1 => 'ЦТ',
            0 => ' - ',
        ];
    }
    
    public static function getObnalichieArray()
    {
        return [
            1 => 'Обязательно',
            0 => ' - ',
        ];
    }
}
