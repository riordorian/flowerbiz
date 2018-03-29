<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrdersScheduleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-schedule-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'CLIENT_ID') ?>

    <?= $form->field($model, 'GIFT_RECIPIENT_ID') ?>

    <?= $form->field($model, 'EVENT_ID') ?>

    <?= $form->field($model, 'SUM') ?>

    <?php // echo $form->field($model, 'RECEIVING_DATE_START') ?>

    <?php // echo $form->field($model, 'RECEIVING_DATE_END') ?>

    <?php // echo $form->field($model, 'NEED_DELIVERY') ?>

    <?php // echo $form->field($model, 'OPERATOR_ID') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'PREPAYMENT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
