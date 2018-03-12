<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Orders;

/**
 * OrdersSearch represents the model behind the search form about `app\models\Orders`.
 */
class OrdersSearch extends Orders
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'CLIENT_ID', 'GIFT_RECIPIENT_ID', 'EVENT_ID', 'NEED_DELIVERY'], 'integer'],
            [['TOTAL', 'PREPAYMENT'], 'number'],
            [['RECEIVING_DATE_START', 'RECEIVING_DATE_END', 'STATUS'], 'safe'],
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
    public function search($arParams)
    {
        $query = Orders::find();

        // add conditions that should always apply here
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($arParams);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'CLIENT_ID' => $this->CLIENT_ID,
            'GIFT_RECIPIENT_ID' => $this->GIFT_RECIPIENT_ID,
            'EVENT_ID' => $this->EVENT_ID,
            'AMOUNT' => $this->TOTAL,
            'RECEIVING_DATE_START' => $this->RECEIVING_DATE_START,
            'RECEIVING_DATE_END' => $this->RECEIVING_DATE_END,
            'NEED_DELIVERY' => $this->NEED_DELIVERY,
            'PREPAYMENT' => $this->PREPAYMENT,
        ]);

        $query->andFilterWhere(['like', 'STATUS', $this->STATUS]);

        if( !empty($arParams['OrdersSearch']['SELLING_TIME']) ){
            $query->andWhere(['between', 'SELLING_TIME', date('Y-m-d H:i:s', strtotime($arParams['OrdersSearch']['SELLING_TIME'] . ' 00:00:00')), date('Y-m-d H:i:s', strtotime($arParams['OrdersSearch']['SELLING_TIME'] . ' 23:59:59'))]);
        }
        
        $query->with(['ordersOperators.operator']);

        return $dataProvider;
    }
}
