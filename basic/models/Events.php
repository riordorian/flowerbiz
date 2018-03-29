<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "events_types".
 *
 * @property integer $ID
 * @property integer $NAME
 */
class Events extends Prototype
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME'], 'required'],
            [['NAME'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NAME' => 'Название события',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientsEvents()
    {
        return $this->hasMany(ClientsEvents::className(), ['EVENT_ID' => 'ID'])->inverseOf('eVENT');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['EVENT_ID' => 'ID'])->inverseOf('event');
    }
}
