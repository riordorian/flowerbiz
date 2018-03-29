<?php

namespace app\models;

class User extends \budyaga\users\models\User
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCashperiods()
    {
        return $this->hasMany(Cashperiods::className(), ['USER_ID' => 'id'])->inverseOf('user');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMoneyMovements()
    {
        return $this->hasMany(MoneyMovements::className(), ['USER_ID' => 'id'])->inverseOf('user');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['USER_ID' => 'ID'])->inverseOf('user');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersOperators()
    {
        return $this->hasMany(OrdersOperators::className(), ['OPERATOR_ID' => 'ID'])->inverseOf('user');
    }
}
