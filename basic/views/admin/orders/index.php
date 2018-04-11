<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Продажи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-types-index">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="js-replaceable-container">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'NAME',
                    'value' => function ($dataProvider) {
                        return Html::a($dataProvider->NAME, '/terminal/orders/get-order-goods/?id=' . $dataProvider->ID, [
                            'class' => 'js-ajax-link',
                            'data-open-type' => 'popup',
                            'data-data-type' => 'html',
                        ]);
                    },
                    'format' => 'raw'
                ],
                'SELLING_TIME',
                [
                    'attribute' => 'TOTAL',
                    'value' => function ($dataProvider) {
                        return number_format($dataProvider->TOTAL, 0, '.', ' ') . ' <i class="fa fa-rub"></i>';
                    },
                    'format' => 'html'
                ],
				[
					'attribute' => 'client.NAME',
					'label' => 'Клиент'
				],
                [
                    'attribute' => 'ordersOperators',
                    'value' => function($dataProvider){
                        foreach($dataProvider->ordersOperators as $k => $obOperator){
                            return $obOperator->operator->username;
                        }
                    },
                    'label' => 'Флорист'
                ],
            ],
            'tableOptions' => [
                'class' => 'table table-striped'
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
