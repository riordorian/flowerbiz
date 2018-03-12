<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Типы событий';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-types-index">
    <p>
        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-primary btn-lg btn-circle btn-add']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'NAME',

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'text-right column column_actions']
            ],
        ],
        'tableOptions' => [
            'class' => 'table table-striped'
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
