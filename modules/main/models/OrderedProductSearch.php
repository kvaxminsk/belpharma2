<?php

namespace app\modules\main\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\main\models\OrderedProduct;

/**
 * OrderedProductSearch represents the model behind the search form about `app\modules\main\models\OrderedProduct`.
 */
class OrderedProductSearch extends OrderedProduct
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'buggod', 'status', 'user_id'], 'integer'],
            [['kolz'], 'string'],
            [['kodpart', 'imn', 'otd', 'dsv'], 'safe'],
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
    public function search($params)
    {
        $query = OrderedProduct::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 200,
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
            'kolz' => $this->kolz,
            'buggod' => $this->buggod,
            'status' => $this->status,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'kodpart', $this->kodpart])
            ->andFilterWhere(['like', 'imn', $this->imn])
            ->andFilterWhere(['like', 'otd', $this->otd])
            ->andFilterWhere(['like', 'dsv', $this->dsv]);

        return $dataProvider;
    }
    
    public function searchAttachToOrder($params)
    {
        $query = OrderedProduct::find()->whereOrderId();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['imn' => SORT_ASC]],
            'pagination' => [
                'pageSize' => 200,

            ]
        ]);
        $this->load($params);
        if(!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'kolz' => $this->kolz,
            'buggod' => $this->buggod,
        ]);
        $query->andFilterWhere(['like', 'kodpart', $this->kodpart])
            ->andFilterWhere(['like', 'imn', $this->imn])
            ->andFilterWhere(['like', 'otd', $this->otd])
            ->andFilterWhere(['like', 'dsv', $this->dsv]);
        return $dataProvider;
    }
    
    public function searchAttachToTheOrder($id, $params)
    {
        $query = OrderedProduct::find()->where(['order_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['imn' => SORT_ASC]],
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);
        $this->load($params);
        if(!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'kolz' => $this->kolz,
            'buggod' => $this->buggod,
        ]);
        $query->andFilterWhere(['like', 'kodpart', $this->kodpart])
            ->andFilterWhere(['like', 'imn', $this->imn])
            ->andFilterWhere(['like', 'otd', $this->otd])
            ->andFilterWhere(['like', 'dsv', $this->dsv]);
        return $dataProvider;
    }
    
    public function searchAttachToOrderWithId($params, $id)
    {
        $query = OrderedProduct::find()->where(['order_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if(!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'kolz' => $this->kolz,
            'buggod' => $this->buggod,
        ]);
        $query->andFilterWhere(['like', 'kodpart', $this->kodpart])
            ->andFilterWhere(['like', 'imn', $this->imn])
            ->andFilterWhere(['like', 'otd', $this->otd])
            ->andFilterWhere(['like', 'dsv', $this->dsv]);
        return $dataProvider;
    }
}
