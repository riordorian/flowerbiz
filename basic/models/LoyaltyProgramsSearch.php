<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LoyaltyPrograms;

/**
 * LoyaltyProgramsSearch represents the model behind the search form about `app\models\LoyaltyPrograms`.
 */
class LoyaltyProgramsSearch extends LoyaltyPrograms
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'MAX_PERCENT', 'WELCOME_BONUS'], 'integer'],
            [['NAME'], 'safe'],
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
        $query = LoyaltyPrograms::find();

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
            'MAX_PERCENT' => $this->MAX_PERCENT,
            'WELCOME_BONUS' => $this->WELCOME_BONUS,
        ]);

        $query->andFilterWhere(['like', 'NAME', $this->NAME]);

        return $dataProvider;
    }
}
