<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients_types".
 *
 * @property integer $ID
 * @property string $NAME
 *
 * @property ClientsClientsTypes[] $clientsClientsTypes
 */
class ClientsTypes extends Prototype
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME'], 'required'],
            [['NAME', 'CODE'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NAME' => 'Тип клиента',
            'CODE' => 'Символьный код',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientsClientsTypes()
    {
        return $this->hasMany(ClientsClientsTypes::className(), ['CLIENT_TYPE_ID' => 'ID'])->inverseOf('CLIENTTYPE');
    }


    
}
