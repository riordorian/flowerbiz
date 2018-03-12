<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CashperiodsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cashperiods-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'OPENING_TIME') ?>

    <?= $form->field($model, 'CLOSING_TIME') ?>

    <?= $form->field($model, 'OPENING_CASH') ?>

    <?= $form->field($model, 'CURRENT_CASH') ?>

    <?php // echo $form->field($model, 'CASHBOX_ID') ?>

    <?php // echo $form->field($model, 'USER_ID') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
