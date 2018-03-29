<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cashboxes".
 *
 * @property integer $ID
 * @property string $NAME
 * @property double $SUMM
 */
class Cashboxes extends Prototype
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cashboxes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME', 'SUMM'], 'required'],
            [['SUMM'], 'number'],
            [['NAME'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID кассы',
            'NAME' => 'Название кассы',
            'SUMM' => 'Сумма денег в кассе',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCashperiods()
    {
        return $this->hasMany(Cashperiods::className(), ['CASHBOX_ID' => 'ID'])->inverseOf('cashbox');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMoneyMovements()
    {
        return $this->hasMany(MoneyMovements::className(), ['CASHBOX_ID' => 'ID'])->inverseOf('cashbox');
    }
}
