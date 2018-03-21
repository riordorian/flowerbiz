<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Прибыль';
$this->params['breadcrumbs'][] = $this->title;?>

<?php  echo $this->render('_profit_search', []); ?>

<? echo GridView::widget([
	'dataProvider' => $dataProvider,
	'summary' => false,
	'columns' => [
		[
			'attribute' => 'ordersCount',
			'label' => 'Количество заказов'
		],
		[
			'attribute' => 'ordersSum',
			'label' => 'Выручка по заказам',
			'format' => 'html',
			'value' => function($dataProvider){
				return number_format($dataProvider['ordersSum'], 0, '.', ' ') . ' <i class="fa fa-rub"></i>';
			},
		],
		[
			'attribute' => 'averageСheck',
			'label' => 'Средний чек',
			'format' => 'html',
			'value' => function($dataProvider){
				return number_format($dataProvider['averageСheck'], 0, '.', ' ') . ' <i class="fa fa-rub"></i>';
			},
		],
		[
			'attribute' => 'goodsConsumption',
			'label' => 'Затраты на продукцию'
		],
		[
			'attribute' => 'operationsConsumptionSum',
			'label' => 'Расходные операции',
			'format' => 'html',
			'value' => function($dataProvider){
				return number_format($dataProvider['operationsConsumptionSum'], 0, '.', ' ') . ' <i class="fa fa-rub"></i>';
			},
		],
		[
			'attribute' => 'operationsIncomeSum',
			'label' => 'Приходные операции',
			'format' => 'html',
			'value' => function($dataProvider){
				return number_format($dataProvider['operationsIncomeSum'], 0, '.', ' ') . ' <i class="fa fa-rub"></i>';
			},
		],
		[
			'attribute' => 'final',
			'label' => 'Прибыль',
			'format' => 'html',
			'value' => function($dataProvider){
				return number_format($dataProvider['final'], 0, '.', ' ') . ' <i class="fa fa-rub"></i>';
			},
		],
	]
]);
