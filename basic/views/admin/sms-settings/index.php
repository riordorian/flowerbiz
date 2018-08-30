<?

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

?><div class="clients-form js-replaceable-container js-reload-elems">

	<div class="panel-body"><?
		$form = ActiveForm::begin([
			'method' => 'post',
			'options' => [
				'class' => 'js-ajax-replaceable'
			]
		]);?>

		<a href="http://flowershoppro.sms.ru/" target="_blank">Личный кабинет в сервисе рассылки sms</a>

		<?= $form->field($obModel, 'ID')->hiddenInput(['value' => 1])->label(false) ?>
		<?= $form->field($obModel, 'ACTIVE')->checkbox(['class' => 'js-widget switcher'])?>
		<?= $form->field($obModel, 'API_ID')->textInput()?>

		<div class="form-group">
			<button class="btn btn-primary js-btn_cloning"><i class="fa fa-check"></i>&nbsp;Сохранить</button>
		</div>
	</div>
	<? ActiveForm::end(); ?>

</div>
