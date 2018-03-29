<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\LoyaltyProgramsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Программы лояльности';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loyalty-programs-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    </p>
    <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-primary btn-lg btn-circle btn-add']) ?>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'NAME',
            'MAX_PERCENT',
            'WELCOME_BONUS',

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'text-right column column_actions']
            ],
        ],
        'tableOptions' => [
            'class' => 'table table-striped'
        ]
    ]); ?>
<?php Pjax::end(); ?></div>
