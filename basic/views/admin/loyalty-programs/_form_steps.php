<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LoyaltyPrograms */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loyalty-programs-steps-form row m-b"><?

    $form = ActiveForm::begin();

        if( !empty($modelStep->ID) ){
            echo $form->field(
                $modelStep,
                'ID'
            )->hiddenInput(['value' => $modelStep->ID])->label(false);
        }


        echo $form->field(
            $modelStep,
            'LOYALTY_PROGRAM_ID'
        )->hiddenInput()->label(false);


        echo $form->field($modelStep, 'TOTAL', [
                'template' => '{input}',
                'options' => [
                    'class' => 'col-md-2'
                ]
        ])->textInput();

        echo $form->field($modelStep, 'CLIENT_GROUP_ID', [
            'template' => '{input}',
            'options' => [
                'class' => 'col-md-3',
            ]
        ])->dropDownList($arGroups, ['prompt' => 'Выберите группу', 'class' => 'js-widget chosen']);

        if( !empty($modelStep->ID) ){
            ?><div class="column_actions p-h-xxs">
                <a href="/admin/loyalty-programs-steps/delete/" class="js-link_del" data-row-id="<?=$modelStep->ID?>">
                    <i class="fa fa-times"></i>
                </a>
            </div><?
        }

    ActiveForm::end();

?></div>