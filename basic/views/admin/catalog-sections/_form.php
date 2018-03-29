<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CatalogSections */
/* @var $form yii\widgets\ActiveForm */

$this->context->fixHeading = 'true';
?>

<div class="catalog-sections-form js-replaceable-container js-reload-elems">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="row">
        <?if( !empty($model->ID) ){
            echo $form->field($model, 'ID')->hiddenInput()->label(false);
        }?>

        <?= $form->field($model, 'NAME', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'SORT', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>

        <div class="clearfix"></div><?
        
        if( !empty($model->IMAGE) ){
            ?><div class="col-md-4 m-b-sm"><?
                echo Html::img($model->IMAGE, ['class' => 'img-responsive']);
            ?></div><?
        }
        ?><div class="clearfix"></div>

        <div class="col-md-4">
            <?= $form->field($model, 'UPLOAD',
                [
                    'template' => '<div class="input-group m-b">{input}<span class="input-group-addon"><i class="fa fa-file-image-o"></i></span></div>'
                ]
            )->fileInput(['class' => 'js-widget uploadpicker ', 'placeholder' => 'Выберите изображение']) ?>
        </div>
    </div>

    <div class="clearfix m-b-lg"></div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-check"></i>&nbsp;Сохранить', ['class' => 'btn btn-primary js-btn_cloning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
