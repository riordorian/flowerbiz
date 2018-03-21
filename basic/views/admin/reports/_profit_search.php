<?php

use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProvidersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="providers-search">

    <?php $form = ActiveForm::begin([
        'action' => ['profit'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="form-group col-md-4">
            <label for="">Даты</label>
            <?=Html::input('text', 'Profit[DATE_FROM]', date('d.m.Y', strtotime('-1 month')), [
                'class' => 'js-widget datepicker form-control'
            ])?>
        </div>
        <div class="form-group col-md-4">
            <label for=""><br></label>
            <?=Html::input('text', 'Profit[DATE_TO]', date('d.m.Y'), [
                'class' => 'js-widget datepicker form-control'
            ])?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Расcчитать', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сбросить', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
