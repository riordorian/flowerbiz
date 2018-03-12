<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Clients;

/**
 * ClientsSearch represents the model behind the search form about `app\models\Clients`.
 */
class ClientsSearch extends Clients
{
    public $CLIENT_GROUP;
    public $CLIENT_TYPE;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'integer'],
            [['NAME', 'GENDER', 'BIRTHDAY', 'PHONE', 'EMAIL', 'DESCRIPTION', 'CLIENT_GROUP', 'CLIENT_TYPE'], 'safe'],
            [['GROUP'], 'safe'],
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
        $query = Clients::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Add sorting by user group
        $query
            ->joinWith('clientsClientsGroups')
            ->joinWith('clientsClientsGroups.clientsGroups')
            ->joinWith('clientsClientsTypes')
            ->joinWith('clientsClientsTypes.clientType');

        $dataProvider->sort->attributes['CLIENT_GROUP'] = [
            'asc' => ['clients_groups.NAME' => SORT_ASC],
            'desc' => ['clients_groups.NAME' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['CLIENT_TYPE'] = [
            'asc' => ['clients_types.NAME' => SORT_ASC],
            'desc' => ['clients_types.NAME' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'BIRTHDAY' => $this->BIRTHDAY,
        ]);
        $query->andFilterWhere(['like', 'clients.NAME', $this->NAME])
            ->andFilterWhere(['like', 'clients_types.ID', $this->CLIENT_TYPE])
            ->andFilterWhere(['like', 'clients_groups.ID', $this->CLIENT_GROUP]);
            /*->andFilterWhere(['like', 'GENDER', $this->GENDER])
            ->andFilterWhere(['like', 'PHONE', $this->PHONE])
            ->andFilterWhere(['like', 'EMAIL', $this->EMAIL])
            ->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION]);*/

        return $dataProvider;
    }
}
