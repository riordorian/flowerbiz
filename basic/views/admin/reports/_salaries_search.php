<?php

use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProvidersSearch */
/* @var $form yii\widgets\ActiveForm */
$arReq = Yii::$app->getRequest()->queryParams;
?>

<div class="providers-search">

    <?php $form = ActiveForm::begin([
        'action' => ['salaries'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="form-group col-md-4">
            <label for="">Флорист</label>
            <?=Html::dropDownList(
                'Salaries[OPERATOR_ID]',
                '',
                ArrayHelper::map($arOperators, 'id', 'username'),
                ['class' => 'js-widget chosen', 'options' => [$arReq['Salaries']['OPERATOR_ID'] => ['selected' => true]]]
            )?>
        </div>
        <div class="form-group col-md-4">
            <label for="">Даты</label>
            <?=Html::input('text', 'Salaries[DATE_FROM]', empty($arReq['Salaries']['DATE_FROM']) ? date('d.m.Y', strtotime('-1 month')) : $arReq['Salaries']['DATE_FROM'], [
                'class' => 'js-widget datepicker form-control'
            ])?>
        </div>
        <div class="form-group col-md-4">
            <label for=""><br></label>
            <?=Html::input('text', 'Salaries[DATE_TO]', empty($arReq['Salaries']['DATE_TO']) ? date('d.m.Y') : $arReq['Salaries']['DATE_TO'], [
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
