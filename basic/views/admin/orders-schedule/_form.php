<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrdersSchedule */
/* @var $form yii\widgets\ActiveForm */


$clockFieldTemplate = "<div class='form-group col-md-6'>
        {label}\n
        <div class='input-group m-b'>
            {input}\n
            <span class='input-group-addon'><span class='fa fa-clock-o'></span></span>
        </div>
    </div>";

$moneyFieldTemplate = "<div class='form-group'>
        {label}\n
        <div class='input-group m-b'>
            <span class='input-group-addon'><i class='fa fa-rub'></i></span>
            {input}\n
            <span class='input-group-addon'>.00</span>
        </div>
    </div>";
?>

<div class="orders-schedule-form">

    <?php $form = ActiveForm::begin(['method' => 'post']); ?>

    <?= $form->field($model, 'NAME')->textInput(['class' => 'form-control js-order-name']) ?>

    <?= $form->field($model, 'CLIENT')->textInput(['class' => 'js-autocomplete-user form-control', 'placeholder' => '9998887755 или ФИО']); ?>

    <?= $form->field($model, 'CLIENT_ID')->hiddenInput(['class' => 'js-client-id-field'])->label(false); ?>
    
    <?= $form->field($model, 'GIFT_RECIPIENT_ID')->dropDownList($arRecipients, ['prompt' => 'Выберите получателя', 'class' => 'js-widget chosen']); ?>

    <?= $form->field($model, 'EVENT_ID')->dropDownList($arEvents, ['prompt' => 'Выберите событие', 'class' => 'js-widget chosen']); ?>


    <?= $form->field($model, 'PREPAYMENT', ['template' => $moneyFieldTemplate])->textInput(['type' => 'number']) ?>

    <div class="row">
        <?= $form->field($model, 'RECEIVING_TIME_START', ['template' => $clockFieldTemplate, 'options' => ['tag' => null]])->textInput(['class' => 'js-widget clockpicker form-control js-order-timeStart', 'data-target' => '#dateStart']) ?>
        
        <?= $form->field($model, 'RECEIVING_TIME_END', ['template' => $clockFieldTemplate, 'options' => ['tag' => null]])->textInput(['class' => 'js-widget clockpicker form-control js-order-timeEnd', 'data-target' => '#dateEnd']) ?>
        
        <?= $form->field($model, 'RECEIVING_DATE_START')->hiddenInput(['id' => 'dateStart', 'class' => 'js-order-date'])->label(false) ?>
        <?= $form->field($model, 'RECEIVING_DATE_END')->hiddenInput(['id' => 'dateEnd'])->label(false) ?>
    </div>


    <?= $form->field($model, 'NEED_DELIVERY')->checkbox(['class' => 'js-widget switcher']) ?>

    <?= $form->field($model, 'OPERATOR_ID')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>

<!--    --><?//= $form->field($model, 'STATUS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'COMMENT')->textarea() ?>

    <?= $form->field($model, 'TYPE')->hiddenInput(['value' => 'P'])->label(false) ?>
    <?= $form->field($model, 'STATUS')->hiddenInput(['value' => 'N'])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-check"></i>&nbsp;Сохранить', ['class' => 'btn btn-primary js-add-order', 'data-insert' => empty($bInsert) ? 0 : 1]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
