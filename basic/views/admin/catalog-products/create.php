<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CatalogProducts */

$this->title = 'Добавление товара';
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="catalog-products-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
