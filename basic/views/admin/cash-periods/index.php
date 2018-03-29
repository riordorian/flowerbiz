<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CashperiodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Кассовые смены';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cashperiods-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i>', ['open'], ['class' => 'btn btn-primary btn-lg btn-circle btn-add  js-widget popup']) ?>
    </p>
    <div class="row">
        <? Pjax::begin(); ?>
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_list',
                'summary' => false,
                'layout' => "{items}\n<div class='col-md-12'>{pager}</div>",
                'itemOptions' => [
                    'tag' => 'div',
                    'class' => 'col-md-6 m-b-md',
                    
                ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
