<?php

use app\models\CatalogSections;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CatalogProductsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catalog-products-search js-reload-elems row">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

<!--    --><?//= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'NAME', ['options' => ['class' => 'col-md-3']])->textInput([
        'class' => 'js-reload-field form-control',
    ]) ?>

<!--    --><?//= $form->field($model, 'CODE') ?>

    <?= $form->field($model, 'CATALOG_SECTION_ID', ['options' => ['class'=> 'col-md-3']])
        ->dropDownList(
            CatalogSections::getFilterValues(),
            [
                'prompt' => 'Любой',
                'class' => 'js-widget chosen js-reload-field'
            ]
        ) ?>

<!--    --><?//= $form->field($model, 'IMAGE') ?>

    <?php // echo $form->field($model, 'BASE_PRICE') ?>

    <?php // echo $form->field($model, 'RETAIL_PRICE') ?>

    <?php // echo $form->field($model, 'EXPIRATION_TIME') ?>

    <?php // echo $form->field($model, 'MIN_COUNT') ?>

    <div class="form-group col-md-2">
        <label class="control-label">&nbsp;</label><br>
        <?= Html::a('Товары в наличии', ['admin/catalog-products', 'CatalogProductsSearch[IN_STOCK]' => 1], [
            'class' => 'btn btn-primary',
        ]) ?>
    </div>

    <div class="form-group col-md-4">
        <label class="control-label">&nbsp;</label><br>
        <?= Html::a('Сбросить', ['admin/catalog-products'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
