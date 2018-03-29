<?php

use app\models\ClientsTypes;
use app\models\ClientsGroups;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClientsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clients-search js-reload-elems">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]);
    ?>

    <div class="row">
        <?= $form->field($model, 'NAME', [
                'options' => [
                    'class' => 'col-md-4'
                ]
            ]
        )->textInput(['class' => 'form-control js-reload-field']) ?>

        <?= $form->field($model, 'CLIENT_TYPE', [
                'options' => [
                    'class' => 'col-md-3 js-reload-field'
                ]
            ]
        )->dropDownList(ClientsTypes::getFilterValues(), ['prompt' => 'Любой', 'class' => 'js-widget chosen']) ?>

        <?= $form->field($model, 'CLIENT_GROUP', [
                'options' => [
                    'class' => 'col-md-3 js-reload-field'
                ]
            ]
        )->dropDownList(ClientsGroups::getFilterValues(), ['prompt' => 'Любая', 'class' => 'js-widget chosen']) ?>
        <div class="form-group col-md-2">
            <label class="control-label">&nbsp;</label><br>
            <?= Html::a('Сбросить', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
