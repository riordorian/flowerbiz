<? use yii\bootstrap\ActiveForm;

?><div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12 white-bg p-sm form-horizontal js-sale-form-wrap" data-sum="<?=$total?>"><?

	?>
	<? 	$form = ActiveForm::begin(
			[
				'method' => 'post',
				'id' => 'sale',
				'action' => '/terminal/orders/save/',
				'layout' => 'horizontal',
				'options' => [
					'class' => 'js-ajax-replaceable',
				],
				'fieldConfig' => [
					'template' => "{beginWrapper}\n{label}{input}\n{error}\n{endWrapper}",
					'inputTemplate' => "<div class='col-md-8 col-sm-4 col-xs-10 pull-right'><div class='input-group m-b'>{input}<span class='input-group-addon'><i class='fa fa-rub'></i></span></div></div>",
					'horizontalCssClasses' => [
						'label' => 'col-md-3 col-sm-2 col-xs-2 control-label text-left',
						'offset' => '',
						'wrapper' => 'm-t-lg',
						'error' => '',
						'hint' => '',
					],
				],
			]
		);
	?>

	<?= $form->field($obOrders, 'CLIENT_ID', ['template' => '{input}', 'inputTemplate' => '{input}', 'options' => ['tag' => false]])->hiddenInput(['value' => $clientId])->label(false); ?>
	<?= $form->field($obOrders, 'ID', ['template' => '{input}', 'inputTemplate' => '{input}', 'options' => ['tag' => false]])->hiddenInput(['value' => $orderId])->label(false); ?>
	<?= $form->field($obOrders, 'TOTAL', ['template' => '{input}', 'inputTemplate' => '{input}', 'options' => ['tag' => false]])->hiddenInput(['value' => $total])->label(false); ?>
	<?= $form->field($obOrders, 'DISCOUNT', ['template' => '{input}', 'inputTemplate' => '{input}', 'options' => ['tag' => false]])->hiddenInput(['value' => $sum - $total])->label(false); ?>
	<?= $form->field($obOrders, 'STEP', ['template' => '{input}', 'inputTemplate' => '{input}', 'options' => ['tag' => false]])->hiddenInput(['value' => 'F'])->label(false); ?>
	<?= $form->field($obOrders, 'OPERATOR_WORK', ['template' => '{input}', 'inputTemplate' => '{input}', 'options' => ['tag' => false]])->hiddenInput(['value' => $bOperatorWork])->label(false); ?>
	<?
		if( !empty($arOperators) ){
			foreach($arOperators as $operatorId){
				echo $form->field($obOrdersOperators, 'OPERATOR_ID[]', ['template' => '{input}', 'inputTemplate' => '{input}', 'options' => ['tag' => false]])->hiddenInput(['value' => $operatorId])->label(false);
			}
		}

		if( !empty($arGoods) ){
			foreach($arGoods as $goodId => $goodAmount){
				echo $form->field($obOrdersGoods, 'GOOD_ID[' . $goodId . ']', ['template' => '{input}', 'inputTemplate' => '{input}', 'options' => ['tag' => false]])->hiddenInput(['value' => $goodAmount])->label(false);
			}
		}
	?>



		<h1 class="text-danger">
			Сумма заказа - <?=$total?> <i class="fa fa-rub"></i><?
			if( !empty($discount) ){
				?><small class="text-lt m-l-sm text-muted"><?=$sum?> <i class="fa fa-rub"></i></small><?
			}

			if( !empty($prepayment) ){
				?><small class="m-l-sm text-muted">(Предоплата: <?=$prepayment?> <i class="fa fa-rub"></i>)</small><?
			}
		?></h1><?

		foreach($arMoneyAccounts as $id => $accountName){
			echo $form->field($obMoneyAccounts, 'BALANCE[' . $id . ']')
				->textInput(['type' => 'number', 'class' => 'js-client-id-field', 'class' => 'form-control input-lg js-cash-field', 'placeholder' => $accountName])
				->label($accountName);
		}

		/*if( !empty($bonus) ){
			*/?><!--<div class="form-group m-t-lg row">
				<label class="col-md-3 col-sm-2 col-xs-2 control-label text-left">Бонус</label>

				<div class="col-md-8 col-sm-4 col-xs-10 pull-right">
					<div class="input-group m-b">
						<input type="number" max="" placeholder="Баллами" class="form-control input-lg">
						<span class="input-group-addon"><i class="fa fa-rub"></i></span>
					</div>
				</div>
			</div>--><?/*
		}*/

		?><!--<div class="form-group m-t-lg row">
			<label class="col-md-4 col-sm-2 col-xs-2 control-label text-left">Закрыть без оплаты</label>

			<div class="col-md-8 col-sm-4 col-xs-10 pull-right">
				<input type="checkbox" placeholder="" name="CLOSE_WITHOUT_PAYMENT" class="form-control input-lg js-widget switcher">
			</div>
		</div>-->

		<hr>
		<h3 class="js-change text-lg">Сдача <span>0</span> <i class="fa fa-rub"></i></h3>

		<div class="text-center m-t-lg">
			<a href="javascript:;" class="btn btn-lg btn-primary js-save-entity" data-reload="true" disabled="">Завершить</a>
		</div>
	<? ActiveForm::end();?>
</div><?