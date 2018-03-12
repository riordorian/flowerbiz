<?php

namespace app\models;

use budyaga\users\models\User;
use Yii;

/**
 * This is the model class for table "orders_operators".
 *
 * @property integer $ID
 * @property integer $OPERATOR_ID
 * @property integer $ORDER_ID
 *
 * @property User $operator
 * @property Orders $order
 */
class OrdersOperators extends Prototype
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders_operators';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['OPERATOR_ID', 'ORDER_ID'], 'required'],
            [['OPERATOR_ID', 'ORDER_ID'], 'integer'],
            [['OPERATOR_ID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['OPERATOR_ID' => 'id']],
            [['ORDER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['ORDER_ID' => 'ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'OPERATOR_ID' => 'Оператор',
            'ORDER_ID' => 'Заказ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperator()
    {
        return $this->hasOne(User::className(), ['id' => 'OPERATOR_ID'])->inverseOf('ordersOperators');
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['ID' => 'ORDER_ID'])->inverseOf('ordersOperators');
    }
}
