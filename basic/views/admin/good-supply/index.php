<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\Vie.w */
/* @var $searchModel app\models\GoodSupplySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Поставки');
$this->params['breadcrumbs'][] = $this->title;

?><div class="good-supply-index"><?
//      echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-primary btn-lg btn-circle btn-add']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'tableOptions' => [
            'class' => 'table table-striped'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'DATE',

//            'provider.NAME',
            
            [
                'attribute' => 'AMOUNT',
                'format' => 'html',
                'value' => function ($dataProvider) {
                    return number_format($dataProvider->AMOUNT, 0, '.', ' ') . ' <i class="fa fa-rub"></i>';
                },
            ],
            [
                'attribute' => 'PAYED',
                'format' => 'html',
                'value' => function ($dataProvider) {
                    return  number_format($dataProvider->PAYED, 0, '.', ' ') . ' <i class="fa fa-rub"></i>';
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'text-right column column_actions']
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
