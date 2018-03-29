<?

use app\models\Utils;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Clients */
/* @var $form yii\widgets\ActiveForm */

$this->context->fixHeading = 'true';

?><div class="clients-form js-replaceable-container js-reload-elems">

    <div class="panel-body"><?
        $form = ActiveForm::begin([
            'method' => 'post',
            'options' => [
                'class' => 'js-ajax-replaceable'
            ]
        ]);?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label('Имя') ?>
        <?= $form->field($model, 'pay')->textInput(['maxlength' => true, 'type' => 'number'])->label('Процент с продаж') ?>

        <div class="form-group">
            <button class="btn btn-primary js-btn_cloning"><i class="fa fa-check"></i>&nbsp;Сохранить</button>
        </div>
    </div>
    <? ActiveForm::end(); ?>

</div>
