<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients_groups".
 *
 * @property integer $ID
 * @property string $NAME
 * @property integer $PERCENT
 *
 * @property ClientsClientsGroups[] $clientsClientsGroups
 */
class ClientsGroups extends Prototype
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients_groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME', 'PERCENT'], 'required'],
            [['PERCENT', 'LOYALTY_PROGRAM_ID'], 'integer'],
            [['NAME'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NAME' => 'Название',
            'PERCENT' => 'Процент скидки',
            'LOYALTY_PROGRAM_ID' => 'Программа лояльности',
            'LOYALTY_PROGRAM' => 'Программа лояльности',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getClientsClientsGroups()
    {
        return $this->hasMany(ClientsClientsGroups::className(), ['CLIENTS_GROUPS_ID' => 'ID']);
    }*/

    public function getClients()
    {
        return $this->hasMany(Clients::className(), ['ID' => 'CLIENT_ID'])
            ->viaTable('clients_clients_groups', ['CLIENTS_GROUPS_ID' => 'ID']);
    }


    /**
     * Relative with loyalties programs
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getLoyaltyPrograms()
    {
        return $this->hasOne(LoyaltyPrograms::className(), ['ID' => 'LOYALTY_PROGRAM_ID']);
    }
}
