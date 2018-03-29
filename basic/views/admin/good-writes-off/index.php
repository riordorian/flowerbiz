<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\Vie.w */
/* @var $searchModel app\models\GoodSupplySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Списания товара');
$this->params['breadcrumbs'][] = $this->title;

?><div class="good-supply-index"><?
//      echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-primary btn-lg btn-circle btn-add']) ?>
    </p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'tableOptions' => [
            'class' => 'table table-striped'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'DATE',
                'label' => 'Дата списания'
            ],

            [
                'attribute' => 'goodsSupplies.good.NAME',
                'value' => function($obWriteOff){
                    $value = '';
                    foreach($obWriteOff->goodsSupplies as $obGoodWriteOff){
                        $value .= $obGoodWriteOff->good->NAME . ' (' . $obGoodWriteOff->AMOUNT . ')<br>';
                    }

                    return $value;
                },
                'format' => 'html'
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'text-right column column_actions']
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
