<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gift_recipients".
 *
 * @property integer $ID
 * @property string $NAME
 *
 * @property ClientsGiftRecipients[] $clientsGiftRecipients
 */
class GiftRecipients extends Prototype
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gift_recipients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME'], 'required'],
            [['NAME'], 'string', 'max' => 30],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientsGiftRecipients()
    {
        return $this->hasMany(ClientsGiftRecipients::className(), ['RECIPIENT_ID' => 'ID'])->inverseOf('rECIPIENT');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['GIFT_RECIPIENT_ID' => 'ID'])->inverseOf('giftRecipient');
    }
}
