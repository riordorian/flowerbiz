<?php

use app\models\CatalogSections;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CatalogProducts */
/* @var $form yii\widgets\ActiveForm */

?><div class="<?=!empty($model->IMAGE) ? 'row' : ''?>"><?
    if( !empty($model->IMAGE) ){
        ?><div class="col-md-6 m-b-sm"><?
            echo Html::img($model->IMAGE, ['class' => 'img-responsive']);
        ?></div><?
    }?>

    <div class="catalog-products-form <?=!empty($model->IMAGE) ? 'col-md-6' : ''?>">
        <div class="row">

            <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data']
            ]);

            $fieldClass = !empty($model->IMAGE) ? 'col-md-12' : 'col-md-6';?>

            <?= $form->field($model, 'NAME', [
                'options' => [
                    'class' => $fieldClass
                ]
            ])->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'CODE', ['options' => ['class' => $fieldClass]])->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'CATALOG_SECTION_ID', ['options' => ['class' => $fieldClass]])
                ->dropDownList(
                    CatalogSections::getFilterValues(),
                    [
                        'class' => 'js-widget chosen'
                    ]
                );?>
            <?= $form->field($model, 'UPLOAD',
                [
                    'options' => [
                        'class' => $fieldClass,
                    ],
                    'template' => '{label}<div class="input-group m-b">{input}<span class="input-group-addon"><i class="fa fa-file-image-o"></i></span></div>'
                ]
            )->fileInput(['class' => 'js-widget uploadpicker', 'placeholder' => $model->getAttributeLabel('UPLOAD')])->label($model->getAttributeLabel('UPLOAD')) ?>

            <?= $form->field($model, 'BASE_PRICE', ['options' => ['class' => $fieldClass]])->textInput(['type' => 'number']) ?>

            <?= $form->field($model, 'RETAIL_PRICE', ['options' => ['class' => $fieldClass]])->textInput(['type' => 'number']) ?>

            <?/*= $form->field($model, 'EXPIRATION_TIME', ['options' => ['class' => $fieldClass]])->textInput(['type' => 'number']) */?><!--

            --><?/*= $form->field($model, 'MIN_COUNT', ['options' => ['class' => $fieldClass]])->textInput(['type' => 'number']) */?>

            <div class="form-group <?=$fieldClass?>">
                <?= Html::submitButton('<i class="fa fa-check"></i>&nbsp;Сохранить', ['class' => 'btn btn-primary js-btn_cloning']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>