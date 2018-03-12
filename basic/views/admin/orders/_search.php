<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EventsTypesSerch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="events-types-search js-reload-elems row">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'SELLING_TIME', ['options' => [
        'class' => 'col-md-4 js-reload-field'
    ]])->textInput([
        'class' => 'js-widget datepicker form-control',
        'value' => date('d.m.Y')
    ]) ?>

    <div class="form-group">
        <label for="">&nbsp;</label>
        <br>
        <?= Html::resetButton('Сбросить', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
