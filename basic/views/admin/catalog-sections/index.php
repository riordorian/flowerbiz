<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CatalogSectionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории товаров';
$this->params['breadcrumbs'][] = $this->title;
$arReq = Yii::$app->request->queryParams;
?>
<div class="catalog-sections-index">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-primary btn-lg btn-circle btn-add']) ?>
    </p><?

    if( !empty($arReq['DELETE_ERROR']) && $arReq['DELETE_ERROR'] == 'Y' ){
        ?><div class="alert alert-danger">Невозможно удалить категорию. Раздел содержит товары</div><?
    }

    ?><div class="js-replaceable-container">
        <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'summary' => false,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'ID',
                    'NAME',
                    'SORT',
                    [
                        'attribute' => 'IMAGE',
                        'format' => ['image',['height'=>'50']],
                    ],

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