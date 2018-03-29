<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EventsTypes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="events-types-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'NAME')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-check"></i>&nbsp;Сохранить', ['class' => 'btn btn-primary js-btn_cloning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
