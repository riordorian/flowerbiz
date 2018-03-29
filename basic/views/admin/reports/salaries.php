<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Расчет зарплаты';
$this->params['breadcrumbs'][] = $this->title;?>

<?php  echo $this->render('_salaries_search', ['arOperators' => $arOperators, 'selectedOperator' => $selectedOperator]); ?>

<?
if( !empty($dataProvider->allModels) ){
	echo GridView::widget([
		'dataProvider' => $dataProvider,
		'summary' => false,
		'showFooter' => true,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'ID',
			[
				'attribute' => 'SELLING_TIME',
				'label' => 'Дата продажи',
				'value' => function($arOrder){
					return date('d.m.Y H:i:s', strtotime($arOrder['SELLING_TIME']));
				}
			],
			[
				'attribute' => 'TOTAL',
				'label' => 'Сумма заказа',
				'format' => 'html',
				'value' => function($arOrder){
					return number_format($arOrder['TOTAL'], 0, '.', ' ') . ' <i class="fa fa-rub"></i>';
				}
			],
			[
				'attribute' => 'SALARY',
				'label' => 'Заработано флористом',
				'format' => 'html',
				'value' => function($arOrder){
					return number_format($arOrder['SALARY'], 0, '.', ' ') . ' <i class="fa fa-rub"></i>';
				},
				'footer' => number_format($total, 0, '.', ' ') . ' <i class="fa fa-rub"></i>',
			],
		]
	]);
}