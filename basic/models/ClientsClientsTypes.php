<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients_clients_types".
 *
 * @property integer $ID
 * @property integer $CLIENT_ID
 * @property integer $CLIENT_TYPE_ID
 *
 * @property Clients $CLIENT
 * @property ClientsTypes $CLIENTTYPE
 */
class ClientsClientsTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients_clients_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CLIENT_ID', 'CLIENT_TYPE_ID'], 'required'],
            [['ID', 'CLIENT_ID', 'CLIENT_TYPE_ID'], 'integer'],
            [['CLIENT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['CLIENT_ID' => 'ID']],
            [['CLIENT_TYPE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ClientsTypes::className(), 'targetAttribute' => ['CLIENT_TYPE_ID' => 'ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CLIENT_ID' => 'Client  ID',
            'CLIENT_TYPE_ID' => 'Client  Type  ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['ID' => 'CLIENT_ID'])->inverseOf('clientsClientsTypes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientType()
    {
        return $this->hasOne(ClientsTypes::className(), ['ID' => 'CLIENT_TYPE_ID'])->inverseOf('clientsClientsTypes');
    }


    /**
     * Getting clientTypeName
     * @return mixed
     */
    public function getClientTypeName()
    {
        return $this->clientType->NAME;
    }
}
