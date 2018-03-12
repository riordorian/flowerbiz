<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "good_supply".
 *
 * @property integer $ID
 * @property string $DATE
 * @property integer $PROVIDER
 * @property double $AMOUNT
 * @property double $PAYED
 *
 * @property Providers $pROVIDER
 */
class GoodSupply extends Prototype
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'good_supply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DATE'], 'required'],
            [['DATE'], 'safe'],
            [['PROVIDER', 'WRITE_OFF'], 'integer'],
            [['AMOUNT', 'PAYED'], 'number'],
            [['PROVIDER'], 'exist', 'skipOnError' => true, 'targetClass' => Providers::className(), 'targetAttribute' => ['PROVIDER' => 'ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'DATE' => 'Дата поставки',
            'PROVIDER' => 'Поставщик',
            'AMOUNT' => 'Сумма закупки',
            'PAYED' => 'Оплачено',
            'WRITE_OFF' => 'Списание',
        ];
    }


    /**
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->DATE = date('Y-m-d H:i:s', strtotime($this->DATE));

        return parent::beforeSave($insert);
    }


    /**
     * @return bool
     */
    public function afterFind()
    {
        $this->DATE = date('d.m.Y H:i', strtotime($this->DATE));
        
        return parent::afterFind();
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsSupplies()
    {
        return $this->hasMany(GoodsSupplies::className(), ['GOOD_SUPPLY_ID' => 'ID'])->inverseOf('goodSupply');
    }
}
