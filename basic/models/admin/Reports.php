<?php

namespace app\models\admin;

use app\models\Orders;
use app\models\OrdersOperators;
use app\models\Prototype;
use Yii;

/**
 * This is the model class for table "events_types".
 *
 */
class Reports extends Prototype
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID'   => 'ID',
            'NAME' => 'Название события',
        ];
    }


    /**
     * Calculating operators salary
     *
     * @param        $operatorId
     * @param string $dateFrom
     * @param string $dateTo
     *
     * @return array
     */
    public function getOperatorSalary($operatorId, $dateFrom = '', $dateTo = '')
    {
        $arSalaryOrders = [
            'TOTAL' => 0,
            'ORDERS' => []
        ];
        $dateFrom = empty($dateFrom) ? date('Y-m-d H:i:s', strtotime(date('d.m.Y') . ' 00:00:00')) : date('Y-m-d H:i:s', $dateFrom);
        $dateTo = empty($dateTo) ? date('Y-m-d H:i:s', strtotime(date('d.m.Y') . ' 23:59:59')) : date('Y-m-d H:i:s', $dateTo);

        $query = Orders::find()
            ->leftJoin(OrdersOperators::tableName(), OrdersOperators::tableName() . '.ORDER_ID=' . Orders::tableName() . '.ID')
            ->addSelect([
                Orders::tableName()  . '.ID',
                'TOTAL',
                'SELLING_TIME'
            ])
            ->andWhere([OrdersOperators::tableName() . '.OPERATOR_ID' => $operatorId])
            ->andWhere(['between', 'SELLING_TIME', $dateFrom, $dateTo])
        ;

        $arOrders = $query->all();
        foreach($arOrders as $obOrder){
            $arSalaryOrders['ORDERS'][$obOrder->ID] = $obOrder->getAttributes();
            $arSalaryOrders['ORDERS'][$obOrder->ID]['SALARY'] = $obOrder->TOTAL * $obOrder->ordersOperators[0]->operator->pay / (100 + $obOrder->ordersOperators[0]->operator->pay);
            $arSalaryOrders['TOTAL'] += $arSalaryOrders['ORDERS'][$obOrder->ID]['SALARY'];
        }
        
        return $arSalaryOrders;
    }


    public function getProfit($operatorId, $dateFrom = '', $dateTo = '')
    {
    }
}
