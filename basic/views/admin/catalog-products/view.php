<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CatalogProducts */

$this->title = $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-products-view">

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить товар?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'NAME',
            'CODE',
            'CATALOG_SECTION_ID',
            [
                'attribute' => 'IMAGE',
                'value' => ($model->IMAGE),
                'format' => ['image',['max-height'=>'200']],
            ],
            'BASE_PRICE',
            'RETAIL_PRICE',
            'AMOUNT',
            /*'EXPIRATION_TIME',
            'MIN_COUNT',*/
        ],
    ]) ?>

</div>
