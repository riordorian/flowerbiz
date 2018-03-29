<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients_clients_groups".
 *
 * @property integer $ID
 * @property integer $CLIENT_ID
 * @property integer $CLIENT_GROUP_ID
 *
 * @property Clients $CLIENT
 * @property ClientsGroups $CLIENTSGROUPS
 */
class ClientsClientsGroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients_clients_groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CLIENT_ID', 'CLIENT_GROUP_ID'], 'required'],
            [['CLIENT_ID', 'CLIENT_GROUP_ID'], 'integer'],
            [['CLIENT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['CLIENT_ID' => 'ID']],
            [['CLIENT_GROUP_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ClientsGroups::className(), 'targetAttribute' => ['CLIENT_GROUP_ID' => 'ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CLIENT_ID' => 'Клиент',
            'CLIENT_GROUP_ID' => 'Группа',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['ID' => 'CLIENT_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientsGroups()
    {
        return $this->hasOne(ClientsGroups::className(), ['ID' => 'CLIENT_GROUP_ID']);
    }


    /**
     * getting groups name
     *
     * @return mixed
     */
    public function getGroupName() {
        return $this->clientsGroups->NAME;
    }
}
