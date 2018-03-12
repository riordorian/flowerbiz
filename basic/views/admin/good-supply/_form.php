<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GoodSupply */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="good-supply-form row js-replaceable-container js-reload-elems">
    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#tab-1">Информация о поставке</a>
            </li>
            <li>
                <a data-toggle="tab" href="#tab-2" class="<?=( $model->isNewRecord ) ? 'disabled' : ''?>">Товары</a>
            </li>
        </ul>

        <div class="tab-content">

            <div id="tab-1" class="tab-pane active">
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'method'  => 'post',
                        'options' => [
                            'class' => 'js-ajax-replaceable'
                        ]
                    ]); ?>

                    <?=$form->field($model, 'DATE', ['options' => ['class' => 'col-md-6']])->textInput(['class' => 'form-control js-widget datetimepicker', 'value' => $model->isNewRecord ? date('d.m.Y H:i') : $model->DATE])?>

                    <?=$form->field($model, 'PROVIDER', ['options' => ['class' => 'col-md-6']])->dropDownList($arProviders, ['class' => 'js-widget chosen'])?>

                    <div class="clearfix"></div>

                    <?=$form->field($model, 'AMOUNT', ['options' => ['class' => 'col-md-6']])->textInput(['type' => 'number'])->label($model->getAttributeLabel('AMOUNT') . ', <i class="fa fa-rub"></i>')?>

                    <?=$form->field($model, 'PAYED', ['options' => ['class' => 'col-md-6']])->textInput(['type' => 'number'])->label($model->getAttributeLabel('PAYED') . ', <i class="fa fa-rub"></i>')?>

                    <div class="form-group col-md-12">
                        <?=Html::submitButton('<i class="fa fa-check"></i>&nbsp;Сохранить', ['class' => 'btn btn-primary js-btn_cloning m-t'])?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div><?
            if( !$model->isNewRecord ){
                ?><div id="tab-2" class="tab-pane">
                    <div class="panel-body"><?
                        ?><div class="row"><?

                            if( !empty($arSupplyGoods) && is_array($arSupplyGoods) ){
                                foreach($arSupplyGoods as $obGood){
                                    echo $this->render('_form_goods.php', [
                                        'model' => $model,
                                        'modelGoodsSupplies' => $obGood,
                                        'arGoods' => $arGoods
                                    ]);
                                }
                            }
                            else{
                                echo $this->render('_form_goods.php', [
                                    'model' => $model,
                                    'modelGoodsSupplies' => $modelGoodsSupplies,
                                    'arGoods' => $arGoods
                                ]);
                            }

                            ?></div><?



                        ?><div class="hidden row js-form_cloned"><?
                            echo $this->render('_form_goods.php', [
                                'model' => $model,
                                'modelGoodsSupplies' => $modelGoodsSupplies,
                                'arGoods' => $arGoods,
                            ]);
                            ?></div>

                        <div class="m-b-md">
                            <a href="javascript:;" class="link text-info js-link_clone" data-cloned=".js-form_cloned">Добавить</a>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary js-btn_cloning"><i class="fa fa-check"></i>&nbsp;Сохранить</button>
                        </div>

                    </div>
                </div><?
            }

        ?></div>
    </div>

</div>
