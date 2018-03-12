<?php

use app\models\Cashboxes;
use app\models\MoneyAccounts;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MoneyMovements */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="money-movements-form white-bg p-m col-md-6 col-md-offset-3 js-ajax-loaded js-replaceable-container">

    <div class="js-reload-elems">
        <?php $form = ActiveForm::begin([
            'errorSummaryCssClass' => 'alert alert-danger',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{hint}\n<div class='help-block'></div>"
            ],
            'options' => [
                'class' => 'js-ajax-replaceable',
                'id' => 'money-movements-form'
            ],
        ]); ?>

        <?= $form->errorSummary($model, ['header' => '']); ?>

        <div class="btn-group m-b-md" data-toggle="buttons"><?
            echo $form
                ->field($model, 'TYPE')
                ->radioList($arTypes, [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        return '<label class="btn btn-primary btn-outline ' . ($checked ? 'active' : '') . '" data-toggle="button">' . Html::radio($name, $checked,
                            [
                                'value' => $value,
//                                'class' => 'js-reload-field',
                            ]
                        ) . '<i></i> ' . $label . '</label>';
                    },
                ])->label('');
            ?></div>

        <div class="row">
            <?= $form->field($model, 'AMOUNT', ['options' => ['class' => 'col-md-6']])->textInput(['type' => 'number']) ?>

            <?
            if( $model->TYPE == 'TRANSFER' ){
                echo $form->field($model, 'MONEY_ACCOUNT_FROM', ['options' => ['class' => 'col-md-6']])
                    ->dropDownList(
                        MoneyAccounts::getFilterValues(),
                        [
                            'class' => 'js-widget chosen'
                        ]
                    );
            } ?>

            <?= $form->field($model, 'MONEY_ACCOUNT', ['options' => ['class' => 'col-md-6']])
                ->dropDownList(
                    MoneyAccounts::getFilterValues(),
                    [
                        'class' => 'js-widget chosen'
                    ]
                );?>

            <?= $form->field($model, 'CASHBOX_ID', ['options' => ['class' => 'col-md-6']])
                ->dropDownList(
                    Cashboxes::getFilterValues(),
                    [
                        'class' => 'js-widget chosen'
                    ]
                );?>

            <?= $form->field($model, 'DATE', ['options' => ['class' => 'col-md-6']])->textInput(['class' => 'form-control js-widget datetimepicker', 'value' => date('d.m.Y H:i:s')]) ?>
        </div>

        <?= $form->field($model, 'COMMENT')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <!--        --><?//= Html::submitButton('<i class="fa fa-check"></i>&nbsp;Сохранить', ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton('<i class="fa fa-check"></i>&nbsp;Сохранить', ['class' => 'btn btn-primary js-btn_cloning']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
