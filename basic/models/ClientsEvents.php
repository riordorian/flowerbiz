<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients_events".
 *
 * @property integer $ID
 * @property integer $CLIENT_ID
 * @property integer $EVENT_ID
 * @property string $EVENT_DATE
 *
 * @property Clients $client
 * @property Events $event
 */
class ClientsEvents extends Prototype
{
    /**
     * @var - date virtual part prop
     */
    public $EVENT_DATE_DAY;

    /**
     * @var - date virtual part prop
     */
    public $EVENT_DATE_MONTH;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients_events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'safe'],
            [['CLIENT_ID', 'EVENT_ID', 'EVENT_DATE', 'GIFT_RECIPIENT_ID'], 'required'],
            [['CLIENT_ID', 'EVENT_ID', 'GIFT_RECIPIENT_ID'], 'integer'],
            [['EVENT_DATE'], 'safe'],
            [['EVENT_DATE_MONTH', 'EVENT_DATE_DAY'], 'string'],
            [['CLIENT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['CLIENT_ID' => 'ID']],
            [['EVENT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Events::className(), 'targetAttribute' => ['EVENT_ID' => 'ID']],
            [['GIFT_RECIPIENT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => GiftRecipients::className(), 'targetAttribute' => ['GIFT_RECIPIENT_ID' => 'ID']],
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
            'EVENT_ID' => 'Тип события',
            'GIFT_RECIPIENT_ID' => 'Получатель',
            'EVENT_DATE_DAY' => 'Дата события',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasMany(Clients::className(), ['ID' => 'CLIENT_ID'])->inverseOf('clientsEvents');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasMany(Events::className(), ['ID' => 'EVENT_ID'])->inverseOf('clientsEvents');
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventDateDay()
    {
        return $this->EVENT_DATE_DAY;
    }
}
