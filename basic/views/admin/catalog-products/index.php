<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CatalogProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-products-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-primary btn-lg btn-circle btn-add']) ?>
    </p>
    <div class="js-replaceable-container">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'summary' => false,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'NAME',
        //            'CODE',
                    [
                        'attribute' => 'CATALOG_SECTION_ID',
                        'value' => 'catalogSection.NAME',
                    ],

                    [
                        'attribute' => 'IMAGE',
                        'format' => ['image',['height'=>'50']],
                    ],
                     'BASE_PRICE',
                     'RETAIL_PRICE',
                     'AMOUNT',

                    /* 'EXPIRATION_TIME',
                     'MIN_COUNT',*/

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['class' => 'text-right column column_actions']
                    ],
                ],
                'tableOptions' => [
                    'class' => 'table table-striped'
                ],
            ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
