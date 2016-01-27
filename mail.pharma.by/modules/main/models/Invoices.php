<?php

namespace app\modules\main\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "invoices".
 *
 * @property integer $id
 * @property string $number
 * @property string $cod
 * @property string $created_at
 * @property string $updated_at
 */
class Invoices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoices';
    }
    
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
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['number', 'cod'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'cod' => 'Cod',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
