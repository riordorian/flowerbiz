<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClientsGroups */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clients-groups-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PERCENT')->textInput() ?>
    
    <?= $form->field($model, 'LOYALTY_PROGRAM_ID')->dropDownList($arLoyalties, ['prompt' => 'Выберите программу лояльности', 'class' => 'js-widget chosen']); ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-check"></i>&nbsp;Сохранить', ['class' => 'btn btn-primary js-btn_cloning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
