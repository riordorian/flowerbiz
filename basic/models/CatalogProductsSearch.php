<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CatalogProducts;

/**
 * CatalogProductsSearch represents the model behind the search form about `app\models\CatalogProducts`.
 */
class CatalogProductsSearch extends CatalogProducts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'CATALOG_SECTION_ID', 'EXPIRATION_TIME', 'MIN_COUNT', 'IN_STOCK'], 'integer'],
            [['NAME', 'CODE', 'IMAGE'], 'safe'],
            [['BASE_PRICE', 'RETAIL_PRICE'], 'number'],
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
        $query = CatalogProducts::find();

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
            'CATALOG_SECTION_ID' => $this->CATALOG_SECTION_ID,
            'BASE_PRICE' => $this->BASE_PRICE,
            'RETAIL_PRICE' => $this->RETAIL_PRICE,
            'EXPIRATION_TIME' => $this->EXPIRATION_TIME,
            'MIN_COUNT' => $this->MIN_COUNT,
        ]);

        # Goods in stock
        if( $this->IN_STOCK == 1 ){
            $query->andFilterWhere(['>', 'AMOUNT', 0]);
        }

        $query->andFilterWhere(['like', 'NAME', $this->NAME])
            ->andFilterWhere(['like', 'CODE', $this->CODE])
            ->andFilterWhere(['like', 'IMAGE', $this->IMAGE]);

        return $dataProvider;
    }
}
