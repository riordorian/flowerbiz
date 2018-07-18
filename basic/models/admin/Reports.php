<?php

namespace app\models\admin;

use app\models\MoneyMovements;
use app\models\Orders;
use app\models\OrdersGoods;
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
            ->andWhere(['between', 'SELLING_TIME', $dateFrom, $dateTo])
            ->andWhere([OrdersOperators::tableName() . '.OPERATOR_ID' => $operatorId])
            ->andWhere(['OPERATOR_WORK' => 1]);
        $arOrders = $query->all();

        foreach($arOrders as $obOrder){
            $arSalaryOrders['ORDERS'][$obOrder->ID] = $obOrder->getAttributes();
            $arSalaryOrders['ORDERS'][$obOrder->ID]['SALARY'] = $obOrder->TOTAL * $obOrder->ordersOperators[0]->operator->pay / (100 + $obOrder->ordersOperators[0]->operator->pay);
            $arSalaryOrders['TOTAL'] += $arSalaryOrders['ORDERS'][$obOrder->ID]['SALARY'];
        }
        
        return $arSalaryOrders;
    }


	/**
	 * Getting profit for period
	 *
	 * @param string $dateFrom
	 * @param string $dateTo
	 *
	 * @return array
	 *
	 */
    public function getProfit($dateFrom = '', $dateTo = '')
    {
    	$obOrders = Orders::find();
		$obOperations = MoneyMovements::find()->andWhere(['ORDER_ID' => null]);
		$obOrders->andFilterWhere(['PAYMENT_STATUS' => 'F', 'STATUS' => 'F']);

		# Formatting date
    	if( !empty($dateFrom) ){
			$obStartTime = new \DateTime($dateFrom);
			$dateFrom = $obStartTime->setTime(0, 0, 0)->format('Y-m-d H:i:s');
    	}
    	if( !empty($dateTo) ){
			$obEndTime = new \DateTime($dateTo);
			$dateTo = $obEndTime->setTime(23, 59, 59)->format('Y-m-d H:i:s');
    	}

    	# Building filters
    	if( !empty($dateFrom) && !empty($dateTo) ){
    	    $obOrders->andFilterWhere([
    	    	'between', 
				'SELLING_TIME',
				$dateFrom,
				$dateTo,
			]);

    	    $obOperations->andFilterWhere([
				'between',
				'DATE',
				$dateFrom,
				$dateTo,
			]);
    	}
    	else{
    		if( !empty($dateFrom) ){
				$obOrders->andFilterWhere(['>=', 'SELLING_TIME', $dateFrom]);
				$obOperations->andFilterWhere(['>=', 'DATE', $dateFrom]);
    		}

			if( !empty($dateTo) ){
				$obOrders->andFilterWhere(['<=', 'SELLING_TIME', $dateTo]);
				$obOperations->andFilterWhere(['<=', 'DATE', $dateTo]);
			}
		}
		$obOrders->with(['ordersGoods', 'ordersGoods.good']);

    	# Orders report
		$arOrders = $obOrders->asArray()->all();

		# Consumptions on buying goods
		$goodsСonsumption = 0;
		if( !empty($arOrders) ){
			foreach($arOrders as $arOrder){
				if( !empty($arOrder['ordersGoods']) ){
					foreach($arOrder['ordersGoods'] as $arOrderGood){
						$goodsСonsumption += $arOrderGood['AMOUNT'] * $arOrderGood['good']['BASE_PRICE'];
					}
				}
			}
		}

		# Operations report
		$arOperations = $obOperations->asArray()->all();
		$arOperationsConsumptions = !empty($arOperations) ? array_filter($arOperations, function($arOperation){
			return $arOperation['TYPE'] == 'CONSUMPTION' && $arOperation['ENCASHMENT'] != 1;
		}) : [];
		$arOperationsIncomes = !empty($arOperations) ? array_filter($arOperations, function($arOperation){
			return $arOperation['TYPE'] == 'INCOME';
		}) : [];
		$arOperationEncashments = !empty($arOperations) ? array_filter($arOperations, function($arOperation){
			return $arOperation['ENCASHMENT'] == 1;
		}) : [];
		$operationsConsumptionSum = !empty($arOperationsConsumptions) ? array_sum(array_column($arOperationsConsumptions, 'AMOUNT')) : 0;
		$operationsIncomeSum = !empty($arOperationsIncomes) ? array_sum(array_column($arOperationsIncomes, 'AMOUNT')) : 0;
		$operationsEncashmentsSum = !empty($arOperationEncashments) ? array_sum(array_column($arOperationEncashments, 'AMOUNT')) : 0;

		$arResult = [
			'ORDERS' => $arOrders,
			'GOODS_CONSUMPTION' => $goodsСonsumption,
			'OPERATIONS' => $arOperations,
			'CONSUMPTION' => $operationsConsumptionSum,
			'ENCASHMENT' => $operationsEncashmentsSum,
			'INCOME' => $operationsIncomeSum
		];

    	return $arResult;
    }
}
