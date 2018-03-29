<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CatalogSections */

$this->title = 'Добавление категории товаров';
$this->params['breadcrumbs'][] = ['label' => 'Категории товаров', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-sections-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
