<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CashboxesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Кассы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cashboxes-index">

<!--    --><?//= $this->render('_search', ['model' => $searchModel]); ?>

    <p>
<!--        --><?//= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-primary btn-lg btn-circle btn-add  js-widget popup']) ?>
    </p>
    <? Pjax::begin(); ?>    
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
//            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

//                'ID',
                'NAME',
                'SUMM',

               /* [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['class' => 'text-right column column_actions'],
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['class' => 'js-widget popup']);
                        },
                    ]
                ],*/
            ],
            'tableOptions' => [
                'class' => 'table table-striped'
            ],
        ]); ?>
    <? Pjax::end(); ?>
</div>
