<?php

namespace app\controllers;

use app\models\admin\Reports;
use app\models\Operators;
use app\models\SolariesSearch;
use Yii;
use app\models\Providers;
use yii\data\ArrayDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReportsController
 */
class ReportsController extends AdminController
{
    /**
     * @var string - base viewPath
     */
    public $viewPath = '/admin/reports/';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Providers models.
     * @return mixed
     */
    public function actionSalaries()
    {
        $arOperators = Operators::getList(['select' => ['id', 'username']]);
        $arSalaryOrders = [];
        $arReq = Yii::$app->request->get();

        if( !empty($arReq['Salaries']['OPERATOR_ID']) ){
            $obReports = new Reports();
            $dateFrom = strtotime($arReq['Salaries']['DATE_FROM'] . ' 00:00:00');
            $dateTo = strtotime($arReq['Salaries']['DATE_TO'] . ' 23:59:59');
            $arSalaryOrders = $obReports->getOperatorSalary($arReq['Salaries']['OPERATOR_ID'], $dateFrom, $dateTo);
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => !empty($arSalaryOrders['ORDERS']) ? $arSalaryOrders['ORDERS'] : [],
        ]);

        return $this->render($this->viewPath . 'salaries', [
            'arOperators' => $arOperators,
            'dataProvider' => $dataProvider,
            'total' => !empty($arSalaryOrders['TOTAL']) ? $arSalaryOrders['TOTAL'] : 0,
            'selectedOperator' => !empty($arReq['Salaries']['OPERATOR_ID']) ? $arReq['Salaries']['OPERATOR_ID'] : reset($arOperators)['id']
        ]);
    }


	/**
	 * Profit report building
	 *
	 * @return string
	 */
    public function actionProfit()
    {
        $arSalaryOrders = [];
        $arReq = Yii::$app->request->get();

        if( !empty($arReq['Profit']) ){
			$obReports = new Reports();
			$dateFrom = $arReq['Profit']['DATE_FROM'];
			$dateTo = $arReq['Profit']['DATE_TO'];
			$arProfit = $obReports->getProfit($dateFrom, $dateTo);
			$ordersCount = !empty($arProfit['ORDERS']) ? count($arProfit['ORDERS']) : 0;
			$ordersSum = $ordersCount > 0 ? array_sum(array_column($arProfit['ORDERS'], 'TOTAL')) : 0;



			$arResult = [[
				'ordersCount' => $ordersCount,
				'ordersSum' => $ordersCount > 0 ? $ordersSum : 0,
				'averageСheck' => $ordersCount > 0 ? $ordersSum / $ordersCount : 0,
				'goodsConsumption' => $arProfit['GOODS_CONSUMPTION'],
				'operationsConsumptionSum' => $arProfit['CONSUMPTION'],
				'operationsIncomeSum' => $arProfit['INCOME'],
				'operationsEncashmentsSum' => $arProfit['ENCASHMENT'],
				'final' => $ordersSum - $arProfit['GOODS_CONSUMPTION'] + $arProfit['INCOME'] - $arProfit['CONSUMPTION']
			]];
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => !empty($arResult) ? $arResult : [],
        ]);
        

        return $this->render($this->viewPath . 'profit', [
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Finds the Providers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Providers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Providers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
