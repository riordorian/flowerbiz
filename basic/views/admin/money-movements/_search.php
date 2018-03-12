<?php

use app\models\MoneyAccounts;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MoneyMovementsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="money-movements-search js-reload-elems">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <?= $form->field($model, 'MONEY_ACCOUNT', ['options' => [
            'class' => 'col-md-4 js-reload-field',
        ]])->dropDownList(
            MoneyAccounts::getFilterValues(),
            [
                'prompt' => 'Любой',
                'class' => 'js-widget chosen'
            ]
        ); ?>

        <?php  echo $form->field($model, 'DATE', ['options' => [
            'class' => 'col-md-4 js-reload-field'
        ]])->textInput(['class' => 'js-widget datepicker form-control']) ?>

        <div class="form-group col-md-4">
            <label class="control-label">&nbsp;</label><br>
            <?= Html::a('Сбросить', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
