<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GoodSupply */

$this->title = Yii::t('app', 'Создание списания товаров');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Списания товаров'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?><div class="good-supply-create">

    <?= $this->render('_form', [
        'model' => $model,
        'arProviders' => $arProviders,
        'modelGoodsSupplies' => '',
        'arGoods' => [],
    ]) ?>

</div>
