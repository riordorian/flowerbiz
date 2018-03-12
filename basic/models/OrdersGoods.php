<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders_goods".
 *
 * @property integer $ID
 * @property integer $ORDER_ID
 * @property integer $GOOD_ID
 *
 * @property OrdersSchedule $oRDER
 * @property CATALOGPRODUCTS $gOOD
 */
class OrdersGoods extends Prototype
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ORDER_ID', 'GOOD_ID', 'AMOUNT'], 'required'],
            [['ORDER_ID', 'GOOD_ID', 'AMOUNT'], 'integer'],
            [['ORDER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['ORDER_ID' => 'ID']],
            [['GOOD_ID'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogProducts::className(), 'targetAttribute' => ['GOOD_ID' => 'ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ORDER_ID' => 'ID заказа',
            'GOOD_ID' => 'ID товара',
            'AMOUNT' => 'Количество',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['ID' => 'ORDER_ID'])->inverseOf('ordersGoods');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasOne(CatalogProducts::className(), ['ID' => 'GOOD_ID'])->inverseOf('ordersGoods');
    }
}
