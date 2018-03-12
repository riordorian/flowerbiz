<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients_gift_recipients".
 *
 * @property integer $ID
 * @property integer $CLIENT_ID
 * @property integer $RECIPIENT_ID
 *
 * @property Clients $cLIENT
 * @property GiftRecipients $rECIPIENT
 */
class ClientsGiftRecipients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients_gift_recipients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CLIENT_ID', 'RECIPIENT_ID'], 'required'],
            [['CLIENT_ID', 'RECIPIENT_ID'], 'integer'],
            [['CLIENT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['CLIENT_ID' => 'ID']],
            [['RECIPIENT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => GiftRecipients::className(), 'targetAttribute' => ['RECIPIENT_ID' => 'ID']],
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
            'RECIPIENT_ID' => 'Тип получателя',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['ID' => 'CLIENT_ID'])->inverseOf('clientsGiftRecipients');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(GiftRecipients::className(), ['ID' => 'RECIPIENT_ID'])->inverseOf('clientsGiftRecipients');
    }
}
