<?php

namespace app\modules\main\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\modules\main\models\Products;

/**
 * ProductsSearch represents the model behind the search form about `app\modules\main\models\Products`.
 */
class ProductsSearch extends Products
{
    public $godenDoFrom;
    public $godenDoTo;
    public $kolFrom;
    public $kolTo;
    public $cenaoptFrom;
    public $cenaoptTo;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'otd', 'osnls', 'tender', 'obnalichie', 'kolotgr', 
                'kolTo', 'kolFrom', 'cenaoptFrom', 'cenaoptTo'], 'integer'],
            [['mnn', 'tn', 'kpr', 'nshort3', 'namepr', 'country', 'spar', 'goden_do', 
                'tendergod', 'vidtovara', 'vidpost', 'godenDoFrom', 'godenDoTo'], 'safe'],
            [['cenopt', 'cenrozn', 'kol'], 'number'],
            //[['godenDoFrom', 'godenDoTo'], 'date'],
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
    
    public function attributeLabels() {
        $a = parent::attributeLabels();
        $b = [
            'godenDoFrom' => 'Годен до',
            'godenDoTo' => ' ',
            'kolFrom' => 'Количество на складе',
            'kolTo' => '(в штуках)',
            'cenaoptFrom' => 'Цена оптовая',
            'cenaoptTo' => ' ',
        ];
        return ArrayHelper::merge($a, $b);
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
        $query = Products::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'otd' => $this->otd,
            'osnls' => $this->osnls,
            'tender' => $this->tender,
            //'goden_do' => $this->goden_do,
            //'cenopt' => $this->cenopt,
            'cenrozn' => $this->cenrozn,
            //'kol' => $this->kol,
            'obnalichie' => $this->obnalichie,
            'kolotgr' => $this->kolotgr,
        ]);

        $query->andFilterWhere(['like', 'mnn', $this->mnn])
            ->andFilterWhere(['like', 'tn', $this->tn])
            ->andFilterWhere(['like', 'kpr', $this->kpr])
            ->andFilterWhere(['like', 'nshort3', $this->nshort3])
            ->andFilterWhere(['like', 'namepr', $this->namepr])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'spar', $this->spar])
            ->andFilterWhere(['like', 'tendergod', $this->tendergod])
            ->andFilterWhere(['like', 'vidtovara', $this->vidtovara])
                ->andFilterWhere(['<=', 'kol', $this->kolTo])
                ->andFilterWhere(['>=', 'kol', $this->kolFrom])
                ->andFilterWhere(['<=', 'goden_do', $this->godenDoTo])
                ->andFilterWhere(['>=', 'goden_do', $this->godenDoFrom])
                ->andFilterWhere(['<=', 'cenopt', $this->cenaoptTo])
                ->andFilterWhere(['>=', 'cenopt', $this->cenaoptFrom])
            ->andFilterWhere(['like', 'vidpost', $this->vidpost]);

        return $dataProvider;
    }
}
