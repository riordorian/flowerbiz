<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatalogSections */

$this->title = 'Обновление категории товаров: ' . $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Категории товаров', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NAME, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="catalog-sections-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
