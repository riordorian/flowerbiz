<?

use app\models\Utils;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Clients */
/* @var $form yii\widgets\ActiveForm */

$form = ActiveForm::begin([
    'method' => 'post',
    'options' => [
        'data-entity' => 'events',
        'class' => 'clearfix'
    ]
]);?>

<? if( !empty($modelCEvents->ID) ){
    echo $form->field(
        $modelCEvents,
        'ID'
    )->hiddenInput(['value' => $modelCEvents->ID])->label(false);
}?>

<?= $form->field(
    $modelCEvents,
    'CLIENT_ID'
)->hiddenInput(['value' => $model->getAttribute('ID')])->label(false);?>

<?= $form->field(
    $modelCEvents,
    'GIFT_RECIPIENT_ID',
    [
        'options' => [
            'class' => 'col-md-3'
        ]
    ]
)->dropDownList($arRecipients, ['prompt' => 'Выберите получателя', 'class' => 'js-widget chosen']);?>

<?= $form->field(
    $modelCEvents,
    'EVENT_ID',
    [
        'options' => [
            'class' => 'col-md-4'
        ]
    ]
)->dropDownList($arEvents, ['prompt' => 'Выберите тип события', 'class' => 'js-widget chosen']);?>

<?= $form->field(
    $modelCEvents,
    'EVENT_DATE_DAY',
    [
        'options' => [
            'class' => 'col-md-2'
        ]
    ]
)->dropDownList(Utils::getDateArray('DATES'), ['prompt' => 'Число', 'class' => 'js-widget chosen']); ?>

<?= $form->field(
    $modelCEvents,
    'EVENT_DATE_MONTH',
    [
        'options' => [
            'class' => 'col-md-2',
        ]
    ]
)->dropDownList(Utils::getDateArray('MONTHES'), ['prompt' => 'Месяц', 'class' => 'js-widget chosen'])->label('<br>');

if( !empty($modelCEvents->ID) ){

    ?><div class="column_actions p-h-xxs">
        <label for="">&nbsp;</label><br>
        <a href="/admin/clients-events/delete/" class="js-link_del" data-row-id="<?=$modelCEvents->ID?>">
            <i class="fa fa-times"></i>
        </a>
    </div><?
}


ActiveForm::end();