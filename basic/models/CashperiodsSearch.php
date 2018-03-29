<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cashperiods;

/**
 * CashperiodsSearch represents the model behind the search form about `\app\models\Cashperiods`.
 */
class CashperiodsSearch extends Cashperiods
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'CASHBOX_ID', 'USER_ID'], 'integer'],
            [['OPENING_TIME', 'CLOSING_TIME'], 'safe'],
            [['OPENING_CASH', 'CURRENT_CASH'], 'number'],
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
        $query = Cashperiods::find();

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
            'OPENING_TIME' => $this->OPENING_TIME,
            'CLOSING_TIME' => $this->CLOSING_TIME,
            'OPENING_CASH' => $this->OPENING_CASH,
            'CURRENT_CASH' => $this->CURRENT_CASH,
            'CASHBOX_ID' => $this->CASHBOX_ID,
            'USER_ID' => $this->USER_ID,
        ]);

        return $dataProvider;
    }
}
