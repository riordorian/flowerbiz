<? use yii\bootstrap\ActiveForm;

?><div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12 white-bg p-sm js-sale-form-wrap" data-sum="<?=$total?>"><?
	?>
	
	<? 	$form = ActiveForm::begin(
			[
				'method' => 'post',
				'id' => 'sale',
				'action' => '/terminal/orders/save/',
				'options' => [
					'class' => 'js-ajax-replaceable',
					'enctype' => 'multipart/form-data'
				],
			]
		);
	?>

	<?= $form->field($obOrders, 'ID', ['template' => '{input}', 'inputTemplate' => '{input}', 'options' => ['tag' => false]])->hiddenInput(['value' => $orderId])->label(false); ?>
	<?= $form->field($obOrders, 'TYPE', ['template' => '{input}', 'inputTemplate' => '{input}', 'options' => ['tag' => false]])->hiddenInput(['value' => empty($arReq['ORDER_ID']) ? 'B' : 'P'])->label(false); ?>
	<?= $form->field($obOrders, 'STATUS', ['template' => '{input}', 'inputTemplate' => '{input}', 'options' => ['tag' => false]])->hiddenInput(['value' => 'C'])->label(false); ?>
	<?= $form->field($obOrders, 'TOTAL', ['template' => '{input}', 'inputTemplate' => '{input}', 'options' => ['tag' => false]])->hiddenInput(['value' => $total])->label(false); ?>
	<?= $form->field($obOrders, 'DISCOUNT', ['template' => '{input}', 'inputTemplate' => '{input}', 'options' => ['tag' => false]])->hiddenInput(['value' => $discount])->label(false); ?>
	<?= $form->field($obOrders, 'STEP', ['template' => '{input}', 'inputTemplate' => '{input}', 'options' => ['tag' => false]])->hiddenInput(['value' => $step])->label(false); ?>
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

	<h2 class="m-b-md">Создание букета</h2>

	<?= $form->field($obOrders, 'NAME', ['options' => []])
		->textInput(['class' => 'form-control', 'placeholder' => 'Название букета', 'value' => empty($arOrder['NAME']) ? '' : $arOrder['NAME']])
		->label('Название букета'); ?>


	<?= $form->field($obOrders, 'UPLOAD',
		[
			'template' => '<div class="input-group m-b">{input}<span class="input-group-addon"><i class="fa fa-file-image-o"></i></span></div>'
		]
	)->fileInput(['class' => 'js-widget uploadpicker ', 'placeholder' => 'Выберите изображение']) ?>



		<div class="text-center m-t-lg">
			<a href="javascript:;" class="btn btn-lg btn-primary js-save-entity" data-reload="true">Сформировать</a>
		</div>
	<? ActiveForm::end();?>
</div><?