<?php

namespace app\modules\admin\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\base\Exception;
use app\modules\main\models\Orders;
use app\modules\main\models\Products;

/**
 * This is the model class for table "import_products".
 *
 * @property integer $id
 * @property string $filename
 * @property string $created_at
 * @property string $updated_at
 * @property integer $user_id
 */
class ImportProducts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'import_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filename'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id', 'countXml', 'countDb'], 'integer'],
            [['notImport'], 'string'],
            [['filename'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Имя файла',
            'created_at' => 'Дата',
            'updated_at' => 'Дата',
            'user_id' => 'User ID',
            'countXml' => 'Количество товаров в xml-файле',
            'countDb' => 'Импортировано в БД',
            'notImport' => 'Список не импортированных товаров',
        ];
    }
    
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)) {
            $this->user_id = Yii::$app->user->getId();
            return true;
        } else {
            return false;
        }    
    }
    
    public function behaviors() 
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ]
        ];
    }
    
    public function uploadXml($file, $dir)
    {
        $filename = uniqid(rand(), true).'.xml';
        $file->saveAs($dir.$filename);
        return $filename;
    }
    
    public function transferXmlToDb()
    {
        $reader = new \XMLReader();
        if(!$reader->open(Yii::getAlias('@webroot') . '/import/' . $this->filename, 'utf-8')) {
            throw new Exception('XML-файл не удалось найти.');
        }
        return $this->parseAndSaveData($reader);
    }
    
    protected function parseAndSaveData($reader)
    {
        Products::deleteAll();
        $report = array(
            'countXml' => 0,
            'countDb' => 0,
            'notImport' => array(),
        );
        while ($reader->read()) 
        {
            if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "Row")
            {
                //increment count row in xml-file
                $report['countXml'] = $report['countXml']+1;
                //AR of the product
                $product = new Products();
                while ($reader->read())
                {
//                    echo ($reader->read().'---'.$reader->name.'</br>');
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "MNN")
                    {
                        $product->mnn = $this->parseRowTag($reader);
                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "TN")
                    {
                        $product->tn = $this->parseRowTag($reader);
                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "Kpr")
                    {
                        $product->kpr = $this->parseRowTag($reader);
                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "nShort3")
                    {
                        $product->nshort3 = $this->parseRowTag($reader);
                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "NamePr")
                    {
                        $product->namepr = $this->parseRowTag($reader);
                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "Country")
                    {
                        $product->country = $this->parseRowTag($reader);
                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "Otd")
                    {
                        $product->otd = $this->parseRowTag($reader);
                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "OsnLS")
                    {
                        $product->osnls = (integer)$this->parseRowTag($reader);
                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "Tender")
                    {
                        $product->tender = (integer)$this->parseRowTag($reader);
                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "Spar")
                    {
                        $product->spar = $this->parseRowTag($reader);
                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "GodenDo")
                    {
                        $product->goden_do = $this->parseRowTag($reader);

                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "CenOpt")
                    {
                        $product->cenopt = $this->parseRowTag($reader);

                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "CenRozn")
                    {
                        $product->cenrozn = $this->parseRowTag($reader);

                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "CenDogovor")
                    {
                        $product->cendogovor = $this->parseRowTag($reader);

                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "Kol")
                    {
                        $product->kol = $this->parseRowTag($reader);

                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "TenderGod")
                    {
                        $product->tendergod = $this->parseRowTag($reader);
                   
                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "VIDTOVARA")
                    {
                        $product->vidtovara = $this->parseRowTag($reader);
                   
                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "OBNALICHIE")
                    {
                        $product->obnalichie = (integer)$this->parseRowTag($reader);

                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "KOLOTGR")
                    {
                        $product->kolotgr = $this->parseRowTag($reader);

                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "VIDPOST")
                    {
                        $product->vidpost = $this->parseRowTag($reader);
                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "NDS")
                    {
                        $product->nds = $this->parseRowTag($reader);
                    }
                    if($reader->nodeType == \XMLReader::ELEMENT && $reader->name == "KodPart")
                    {
                        $product->kodpart = $this->parseRowTag($reader);

                        break;
                    }

                }
                if($product->save()) {
                    $report['countDb'] = $report['countDb']+1;
                } else {
                    $report['notImport'][] = 'код: ' .$product->kpr . ', тн: ' .$product->tn . ';';
                }
            } 
        }
        return $report;
    }
    
    protected function parseRowTag($reader)
    {
        $value = NULL;
        $i=0;
        while($reader->read())
        {
            if($reader->nodeType == \XMLReader::TEXT && $reader->hasValue == TRUE) 
            {
                $value = $reader->value;
                break;
            }
            $i++;
            if($i>=2) {
                break;
            }
        }
        return $value;
    }
}
