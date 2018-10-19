<?

use app\models\Utils;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Clients */
/* @var $form yii\widgets\ActiveForm */

$this->context->fixHeading = 'true';

?><div class="clients-form js-replaceable-container js-reload-elems">
    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab-1">Основное</a></li>
            <li><a data-toggle="tab" href="#tab-2" class="<?=( $model->isNewRecord ) ? 'disabled' : ''?>">События</a></li>
<!--            <li><a data-toggle="tab" href="#tab-3" class="--><?//=( $model->isNewRecord ) ? 'disabled' : ''?><!--">Задачи</a></li>-->
        </ul>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane active">
                <div class="panel-body"><?
                    $form = ActiveForm::begin([
                        'method' => 'post',
                        'options' => [
                            'class' => 'js-ajax-replaceable'
                        ]
                    ]);

                    ?><div class="btn-group m-b-md" data-toggle="buttons"><?
                        echo $form
                            ->field($modelCCTypes, 'CLIENT_TYPE_ID')
                            ->radioList($arCTypes, [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    return '<label class="btn btn-primary btn-outline ' . ($checked ? 'active' : '') . '" data-toggle="button">' . Html::radio($name, $checked,
                                        [
                                            'value' => $value,
                                            'class' => 'js-reload-field',
                                        ]
                                    ) . '<i></i> ' . $label . '</label>';
                                },
                            ])->label('');
                    ?></div>

                    <?= $form->field($model, 'NAME')->textInput(['maxlength' => true])->label($nameLabel) ?>

                    <? if( !empty($bDefCTypeChecked) ){
                        ?><div class="btn-group m-b-md" data-toggle="buttons"><?
                            echo $form->field($model, 'GENDER')->radioList(['М' => 'М', 'Ж' => 'Ж'], [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    return '<label class="btn btn-primary btn-outline ' . ($checked ? 'active' : '') . '" data-toggle="button">' . Html::radio($name, $checked,
                                        [
                                            'value' => $value,
                                        ]
                                    ) . '<i></i> ' . $label . '</label>';
                                },
                            ]);
                        ?></div><?
                    } ?>

                    <div class="row">
                        <?= $form->field($model, 'BIRTHDAY_DAY', ['options' => ['class' => 'col-md-2']])->dropDownList(Utils::getDateArray('DATES'), ['prompt' => 'Число', 'class' => 'js-widget chosen']); ?>
                        <?= $form->field($model, 'BIRTHDAY_MONTH', ['options' => ['class' => 'col-md-2']])->dropDownList(Utils::getDateArray('MONTHES'), ['prompt' => 'Месяц', 'class' => 'js-widget chosen'])->label('<br>') ?>
                        <?= $form->field($model, 'BIRTHDAY_YEAR', ['options' => ['class' => 'col-md-2']])->dropDownList(Utils::getDateArray('YEARS'), ['prompt' => 'Год', 'class' => 'js-widget chosen'])->label('<br>') ?>
                    </div>

                    <?= $form->field($model, 'PHONE')->textInput(['maxlength' => true, 'data-mask' => '+7 (999) 999-99-99']) ?>

                    <?= $form->field($model, 'EMAIL')->textInput(['maxlength' => true])->input('email'); ?>

                    <?= $form->field($modelCCGroups, 'CLIENT_GROUP_ID')->dropDownList($arCGroups, ['prompt' => 'Выберите группу', 'class' => 'js-widget chosen']); ?>

                    <?= $form->field($model, 'DESCRIPTION')->textarea(['rows' => 6]) ?>

                    <div class="form-group">
                        <button class="btn btn-primary js-btn_cloning"><i class="fa fa-check"></i>&nbsp;Сохранить</button>
                    </div>
                </div>
                <? ActiveForm::end(); ?>
            </div><?

            if( !$model->isNewRecord ){
                ?><div id="tab-2" class="tab-pane">
                    <div class="panel-body"><?
                        ?><div class="row"><?
                            if( !empty($arModelCEvents) && is_array($arModelCEvents) ){
                                foreach($arModelCEvents as $modelCEvent){
                                    echo $this->render('_form_events.php', [
                                        'model' => $model,
                                        'modelCEvents' => $modelCEvent,
                                        'arRecipients' => $arRecipients,
                                        'arEvents' => $arEvents
                                    ]);
                                }
                            }
                            else{
                                echo $this->render('_form_events.php', [
                                    'model' => $model,
                                    'modelCEvents' => $modelCEvents,
                                    'arRecipients' => $arRecipients,
                                    'arEvents' => $arEvents
                                ]);
                            }
                            ?></div><?


                        ?><div class="hidden row js-form_cloned"><?
                            echo $this->render('_form_events.php', [
                                'model' => $model,
                                'modelCEvents' => $modelCEvents,
                                'arRecipients' => $arRecipients,
                                'arEvents' => $arEvents
                            ]);
                        ?></div>

                        <div class="m-b-md">
                            <a href="javascript:;" class="link text-info js-link_clone" data-cloned=".js-form_cloned">Добавить</a>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary js-btn_cloning"><i class="fa fa-check"></i>&nbsp;Сохранить</button>
                        </div>

                    </div>
                </div>

                <div id="tab-3" class="tab-pane">
                    <div class="panel-body">
                        2

                        <div class="form-group">
                            <?= Html::submitButton('<i class="fa fa-check"></i>&nbsp;Сохранить', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div><?
            }

        ?></div>
    </div>



</div>
