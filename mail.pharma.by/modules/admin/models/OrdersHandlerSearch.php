<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\modules\admin\models\OrdersHandler;
use app\modules\user\models\User;

/**
 * OrdersHandlerSearch represents the model behind the search form about `app\modules\main\models\Orders`.
 */
class OrdersHandlerSearch extends Model
{
    public $id;
    public $date;
    public $nameUser;
    public $codUser;
    public $price;
    public $countProducts;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'countProducts', 'id', 'codUser'], 'integer'],
            [['nameUser'], 'string'],
            [['date', ], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        //$attributes = parent::attributeLabels();
        $attributesSearch = [
            'id' => 'ID заказа',
            'date' => 'Дата',
            'nameUser' => 'Наименование контрагента',
            'codUser' => 'Код контрагента',
            'price' => 'Сумма',
            'countProducts' => 'Товаров',
            //'user_id' => 'ID контрагента'
        ];
        return $attributesSearch;
    }

    public function search($params)
    {
        $query = OrdersHandler::find()->where(['status' => OrdersHandler::STATUS_SENDED]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            //$query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,            
        ]);
        
        //$userFoundCod = $this->getUsersFoundCod();
        //if(isset($userFoundCod)) {
        //    foreach ($userFoundCod as $user) {
        //        $query->andFilterWhere([
        //            'user_id' => $user->id
        //        ]);
        //    }
        //}
        
        $query->andFilterWhere(['in', 'user_id', $this->codUser ? $this->getUsersFoundCod() : null]);
        $query->andFilterWhere(['user_id' => $this->nameUser ? $this->getUsersFoundName() : null]);
        
        return $dataProvider;
    }
    
    protected function getUsersFoundName()
    {
        $users = User::find()->where(['like', 'name', $this->nameUser])->all();
        if(!empty($users)) {
            $userIds = array();
            foreach ($users as $u) {
                $userIds[] = $u->id;
            }
            return $userIds;
        }
        
        return array(0);
    }
    
    protected function getUsersFoundCod()
    {
        $user = User::find()->where(['cod' => $this->codUser])->one();
        if(isset($user)) {
            return $user->id;
        } else {
            return 0;
        }
    }
}
