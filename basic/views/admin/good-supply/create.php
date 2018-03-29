<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GoodSupply */

$this->title = Yii::t('app', 'Создание поставки');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Поставки'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?><div class="good-supply-create">

    <?= $this->render('_form', [
        'model' => $model,
        'arProviders' => $arProviders,
        'modelGoodsSupplies' => '',
        'arGoods' => [],
    ]) ?>

</div>
