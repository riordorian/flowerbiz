<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GoodSupply;

/**
 * GoodSupplySearch represents the model behind the search form about `app\models\GoodSupply`.
 */
class GoodSupplySearch extends GoodSupply
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'PROVIDER', 'WRITE_OFF'], 'integer'],
            [['DATE'], 'safe'],
            [['AMOUNT', 'PAYED'], 'number'],
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
        $query = GoodSupply::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'DATE' => $this->DATE,
            'PROVIDER' => $this->PROVIDER,
            'AMOUNT' => $this->AMOUNT,
            'PAYED' => $this->PAYED,
            'WRITE_OFF' => empty($this->WRITE_OFF) ? 0 : $this->WRITE_OFF,
        ]);

        # TODO: Подумать, как убрать жадную выборку для неиндексных страниц
        $query->with(['goodsSupplies.good' => function($query){ $query->select(['ID', 'NAME']); }]);

        return $dataProvider;
    }
}
