<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MoneyAccounts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="money-accounts-form">
    <div class="row">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'NAME', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>

        <?= $form
            ->field($model, 'TYPE', ['options' => ['class' => 'col-md-4']])
            ->dropDownList(
                [
                    'CASH' => 'Наличные',
                    'CARD' => 'Банковская карта',
                    'BANK_ACCOUNT' => 'Банковский счет',
                ],
                [
                    'prompt' => 'Выберите группу',
                    'class' => 'js-widget chosen'
                ]);?>

        <?= $form->field($model, 'BALANCE', ['options' => ['class' => 'col-md-4']])->textInput(['type' => 'number', 'min' => 0]) ?>

        <?= $form->field($model, 'USE_ON_CASHBOX', ['options' => ['class' => 'col-md-3 m-t-sm m-b-sm']])->checkbox(['class' => 'js-widget switcher']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-check"></i>&nbsp;Сохранить', ['class' => 'btn btn-primary js-btn_cloning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
