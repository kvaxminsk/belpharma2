<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about `app\modules\user\models\User`.
 */
class UserSearch extends Model
{
    public $id;
    public $username;
    public $email;
    public $cod;
    public $address;
    public $name;
    public $phone;
    public $status;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'email', 'cod', 'name', 'phone', 'address'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $query)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => SORT_DESC,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'cod', $this->cod])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'address', $this->address]);
        
        return $dataProvider;
    }
    
    
    public function searchContragents($params)
    {
        $query = User::find()->where(['role' => 2]);

        $dataProvider = $this->search($params, $query);

        return $dataProvider;
    }
    
    public function searchAdministrators($params)
    {
        $query = User::find()->where(['role' => 1]);
        $dataProvider = $this->search($params, $query);
        return $dataProvider;
    }
}
