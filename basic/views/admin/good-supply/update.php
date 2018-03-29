<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GoodSupply */

$this->title = Yii::t('app', 'Обновление поставки: ', [
    'modelClass' => 'Good Supply',
]) . $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Поставки'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Обновление');
?>
<div class="good-supply-update">

    <?= $this->render('_form', [
        'model' => $model,
        'arProviders' => $arProviders,
        'modelGoodsSupplies' => $modelGoodsSupplies,
        'arGoods' => $arGoods,
        'arSupplyGoods' => $arSupplyGoods
    ]) ?>

</div>
