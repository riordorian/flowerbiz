<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ClientsClientsGroups;

/**
 * ClientsClientsGroupsSearch represents the model behind the search form about `app\models\ClientsClientsGroups`.
 */
class ClientsClientsGroupsSearch extends ClientsClientsGroups
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'CLIENT_ID', 'CLIENTS_GROUPS_ID'], 'integer'],
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
        $query = ClientsClientsGroups::find();
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
            'clients_groups.GROUP_NAME' => $this->groupName,
            'ID' => $this->ID,
            'CLIENT_ID' => $this->CLIENT_ID,
            'CLIENTS_GROUPS_ID' => $this->CLIENTS_GROUPS_ID,
        ]);

        return $dataProvider;
    }
}
