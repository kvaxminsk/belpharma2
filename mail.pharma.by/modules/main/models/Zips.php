<?php

namespace app\modules\main\models;

use Yii;

/**
 * This is the model class for table "zips".
 *
 * @property integer $id
 * @property integer $contragent_cod
 * @property string $filename
 * @property string $created_at
 * @property string $updated_at
 * @property integer $count_file
 */
class Zips extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zips';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contragent_cod', 'count_file'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
            'contragent_cod' => 'Contragent Cod',
            'filename' => 'Filename',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'count_file' => 'Count File',
        ];
    }
}
