<?

use app\models\Utils;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Clients */
/* @var $form yii\widgets\ActiveForm */

?><div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12 white-bg p-sm"><?


    $form = ActiveForm::begin([
        'method' => 'post',
        'options' => [
            'class' => 'js-ajax-replaceable'
        ]
    ]);?>

        <?= $form->field($modelCCTypes, 'CLIENT_TYPE_ID')->hiddenInput(['value' => 1])->label(false)?>

        <? if( !empty($bDefCTypeChecked) ){
            ?><div class="btn-group m-b-md" data-toggle="buttons"><?
            echo $form->field($model, 'GENDER')->radioList(['М' => 'М', 'Ж' => 'Ж'], [
                'item' => function ($index, $label, $name, $checked, $value) use ($model) {
                    return '<label class="btn btn-primary btn-outline ' . ($checked ? 'active' : '') . '" data-toggle="button">' . Html::radio($name, $checked,
                        [
                            'value' => $value,
                        ]
                    ) . '<i></i> ' . $label . '</label>';
                },
            ]);
            ?></div><?
        } ?>

        <?= $form->field($model, 'NAME')->textInput(['maxlength' => true])->label($nameLabel) ?>



        <div class="row">
            <?= $form->field($model, 'BIRTHDAY_DAY', ['options' => ['class' => 'col-md-2']])->dropDownList(Utils::getDateArray('DATES'), ['prompt' => 'Число', 'class' => 'js-widget chosen']); ?>
            <?= $form->field($model, 'BIRTHDAY_MONTH', ['options' => ['class' => 'col-md-2']])->dropDownList(Utils::getDateArray('MONTHES'), ['prompt' => 'Месяц', 'class' => 'js-widget chosen'])->label('<br>') ?>
            <?= $form->field($model, 'BIRTHDAY_YEAR', ['options' => ['class' => 'col-md-2']])->dropDownList(Utils::getDateArray('YEARS'), ['prompt' => 'Год', 'class' => 'js-widget chosen'])->label('<br>') ?>
        </div>

        <?= $form->field($model, 'PHONE')->textInput(['maxlength' => true, 'data-mask' => '+7 (999) 999-99-99']) ?>

        <?= $form->field($modelCCGroups, 'CLIENT_GROUP_ID')->dropDownList($arCGroups, ['prompt' => 'Выберите группу', 'class' => 'js-widget chosen']); ?>

        <?= $form->field($model, 'EMAIL')->textInput(['maxlength' => true])->input('email'); ?>

        <div class="form-group">
            <button class="btn btn-primary js-save-entity"><i class="fa fa-check"></i>&nbsp;Сохранить</button>
        </div>
    <? ActiveForm::end(); ?>
</div>