<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\OrdersSchedule */

$this->title = $model->NAME;
?>
<div class="orders-schedule-view js-ajax-replaceable white-bg p-sm">

    <h1 class="m-b-lg"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary js-open-edit-form']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить заказ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'template' => function($arAttr, $index, $widget){
            if( !empty($arAttr['value']) ) {
                if( in_array($arAttr['attribute'], ['RECEIVING_DATE_START', 'RECEIVING_DATE_END']) ){
                    $obDate = new DateTime();
                    $obDate->setTimestamp(strtotime($arAttr['value']));
                    $arAttr['value'] = $obDate->format('H:i');
                }
                
                return "<tr><th>{$arAttr['label']}</th><td>{$arAttr['value']}</td></tr>";
            }
        },
        'attributes' => [
            'ID',
            'client.NAME',
            'GIFT_RECIPIENT',
            'EVENT',
            'SUM_FORMATTED',
            'PREPAYMENT_FORMATTED',
            'RECEIVING_DATE_START',
            'RECEIVING_DATE_END',
            [
                'attribute' => 'NEED_DELIVERY',
                'label' => $model->getAttributeLabel('NEED_DELIVERY'),
                'value' => $model->NEED_DELIVERY == 1 ? 'Да' : 'Нет',
            ],
            'OPERATOR',
        ],
    ]) ?>

    <div class="text-center"><?
        if( $model->STATUS == 'N'){
            echo Html::a('Собрать', ['/terminal/orders/', 'ORDER_ID' => $model->ID, 'CLIENT_ID' => $model->CLIENT_ID, 'COMMENT' => $model->COMMENT], ['class' => 'btn btn-primary btn-lg']);
        }
        if( $model->STATUS == 'C'){
            $obForm = ActiveForm::begin();

            echo Html::input('hidden', 'DISCOUNT', $model->DISCOUNT);
            echo Html::input('hidden', 'TOTAL', $model->TOTAL);
            echo Html::input('hidden', 'SUM', $model->TOTAL + $model->DISCOUNT);
            echo Html::input('hidden', 'CLIENT_ID', $model->CLIENT_ID);
            echo Html::input('hidden', 'ORDER_ID', $model->ID);

            echo Html::a('Продажа', ['javascript:;'], ['class' => 'btn btn-primary btn-lg js-sale-link', 'data-open-type' => 'popup', 'data-href' => '/terminal/orders/sale/']);
            ActiveForm::end();
        }
    ?></div>

</div>
