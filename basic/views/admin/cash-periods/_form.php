<? use app\models\Cashboxes;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Cashperiods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cashperiods-form white-bg p-m col-md-6 col-md-offset-3 js-ajax-loaded js-replaceable-container">

    <?php $form = ActiveForm::begin([
        'errorSummaryCssClass' => 'alert alert-danger',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{hint}\n<div class='help-block'></div>"
        ],
        'options' => [
            'class' => 'js-ajax-replaceable',
            'id' => 'money-movements-form'
        ],
    ]); ?>

    <?= html_entity_decode($form->errorSummary($model, ['header' => ''])); ?><?

    if( !empty($model->errors['CASH_DIFFERENCE']) ){
        echo $form->field($model, 'MAKE_TRANSACTION')->hiddenInput(['value' => 'Y'])->label(false);
        echo $form->field($model, 'TRANSACTION_AMOUNT')->hiddenInput(['value' => $model->CASH_DIFFERENCE])->label(false);
    }

    ?><?= $form->field($model, 'OPENING_CASH')->textInput(['type' => 'number', 'min' => 0]) ?>

    <?= $form->field($model, 'CASHBOX_ID')->dropDownList(
        Cashboxes::getFilterValues(),
        [
            'class' => 'js-widget chosen'
        ]
    ); ?>
 <?
 
 ?>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-check"></i>&nbsp;Сохранить', ['class' => 'btn btn-primary js-btn_cloning js-save-entity']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
