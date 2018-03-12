<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LoyaltyPrograms */
/* @var $form yii\widgets\ActiveForm */

$this->context->fixHeading = 'true';
?>

<div class="loyalty-programs-form"><?
    $modelsCnt = count($arModels);
    foreach($arModels as $i => $model){
        ?><h2 class="m-b-md"><?=$model->getAttribute('NAME')?></h2><?

            $form = ActiveForm::begin();

                echo  $form->field($model, 'ID', [
                    'template' => '{input}',
                    'options' => [
                        'tag' => null,
                    ]])->hiddenInput();


                if( $model->CODE == 'BONUS' ){
                    echo $form->field($model, 'MAX_PERCENT')->textInput();
                }

                echo $form->field($model, 'WELCOME_BONUS')->textInput();

            ActiveForm::end();


            ?><label>Условия перехода</label><?

            # show loyalty steps forms
            if( !empty($arModelSteps[$model->ID]) && is_array($arModelSteps[$model->ID]) ){
                foreach($arModelSteps[$model->ID] as $modelStep){
                    $modelStep->LOYALTY_PROGRAM_ID = $model->ID;
                    echo $this->render('_form_steps.php', [
                        'modelStep' => $modelStep,
                        'arGroups' => $arGroups[$model->ID],
                    ]);
                }
            }
            # adding loyalty steps forms
            else{
                $modelSteps->LOYALTY_PROGRAM_ID = $model->ID;
                echo $this->render('_form_steps.php', [
                    'modelStep' => $modelSteps,
                    'arGroups' => $arGroups[$model->ID],
                ]);
            }


            ?><div class="m-b-md">
                <a href="javascript:;" class="link text-info js-link_clone" data-cloned=".js-form_cloned">Добавить</a>
            </div><?


            if( $modelsCnt > 1 ){
                ?><div class="m-lg"><br></div><?
            }

            ?><div class="hidden js-form_cloned"><?
                $modelStep->ID = false;
                echo $this->render('_form_steps.php', [
                    'modelStep' => $modelStep,
                    'modelSteps' => $modelSteps,
                    'arGroups' => $arGroups[$model->ID]
                ]);
            ?></div><?
    }



    ?><div class="form-group">
        <?= Html::submitButton('<i class="fa fa-check"></i>&nbsp;Сохранить', ['class' => 'btn btn-primary js-btn_cloning']) ?>
    </div>

</div>
