<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatalogProducts */

$this->title = 'Обновление товара: ' . $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NAME, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="catalog-products-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
