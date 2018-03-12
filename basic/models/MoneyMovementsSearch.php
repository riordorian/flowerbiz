<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MoneyMovements;

/**
 * MoneyMovementsSearch represents the model behind the search form about `app\models\MoneyMovements`.
 */
class MoneyMovementsSearch extends MoneyMovements
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'TYPE', 'AMOUNT', 'MONEY_ACCOUNT', 'ORDER_ID'], 'integer'],
            [['NAME', 'DATE', 'COMMENT'], 'safe'],
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
        $query = MoneyMovements::find();

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
            'TYPE' => $this->TYPE,
            'AMOUNT' => $this->AMOUNT,
            'MONEY_ACCOUNT' => $this->MONEY_ACCOUNT,
            'ORDER_ID' => $this->ORDER_ID,
        ]);
        
        if( !empty($params['MoneyMovementsSearch']['DATE']) ){
            $query->andWhere(['between', 'DATE', date('Y-m-d H:i:s', strtotime($this->DATE . ' 00:00:00')) , date('Y-m-d H:i:s', strtotime($this->DATE . ' 23:59:59'))]);
        }
        
        $query->andFilterWhere(['like', 'NAME', $this->NAME])
            ->andFilterWhere(['like', 'COMMENT', $this->COMMENT]);
        
        return $dataProvider;
    }
}
