<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CatalogSectionsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catalog-sections-search row js-reload-elems">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'NAME', [
        'options' => [
            'class' => 'col-md-4'
        ]
    ])->textInput(['class' => 'form-control js-reload-field']) ?>

    <div class="form-group col-md-2">
        <label class="control-label">&nbsp;</label><br>
        <?= Html::a('Сбросить', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>