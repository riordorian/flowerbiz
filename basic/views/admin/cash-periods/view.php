<? $intClosingTime = strtotime($model->CLOSING_TIME);

?><div class="white-bg p-m col-md-8 col-md-offset-2 js-ajax-loaded js-replaceable-container cash-period" data-cashbox-id="<?=$model->ID?>">
	<div class="tabs-container">
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#tab-1">Основное</a></li><?
			if( !empty($arMoneyMovements) ){
			    ?><li><a data-toggle="tab" href="#tab-2" class="">Операции</a></li><?
			}
		?></ul>
		<div class="tab-content">
			<div id="tab-1" class="tab-pane active">
				<div class="cash-period__inner cash-period__inner_light">
					<h2 class="m-t link">
						Смена <?=$model->ID?>
						<i class="m-l fa <?=($intClosingTime < 0) ? 'fa-unlock' : 'fa-lock'?>"></i>
					</h2>
					<div class="cash-period__info">
						<p class="field field_user">
							<b>Ответственный: </b> <?=$model->USER_NAME?>
						</p>
						<p class="field field_opening-cash">
							<b><?=$model->getAttributeLabel('CASHBOX_ID')?>: </b> <?=$model->cashbox->NAME?>
						</p>
						<p class="field field_opening-cash">
							<b><?=$model->getAttributeLabel('OPENING_CASH')?>: </b> <?=$model->OPENING_CASH?> <i class="fa fa-rub"></i>
						</p>
						<p class="field field_opening-cash">
							<b><?=( $intClosingTime < 0 ) ? $model->getAttributeLabel('CURRENT_CASH') : 'Денег на момент закрытия'?>: </b>
							<?=( empty($arMoneyMovements) ) ? $model->OPENING_CASH : $model->OPENING_CASH + $model->CASH_INCOMES + $model->CARDS_INCOMES?>  <i class="fa fa-rub"></i>
						</p>
						<p class="field field_opening-cash">
							<b><?=$model->getAttributeLabel('PROFIT')?>: </b> <?=$model->CASH_INCOMES + $model->CARDS_INCOMES ?>  <i class="fa fa-rub"></i>
						</p>
						<p class="field field_opening-cash">
							<b><?=$model->getAttributeLabel('CASH_PROFIT')?>: </b> <?=$model->CASH_INCOMES?>  <i class="fa fa-rub"></i>
						</p>
						<p class="field field_opening-cash">
							<b><?=$model->getAttributeLabel('CARDS_PROFIT')?>: </b> <?=$model->CARDS_INCOMES?>  <i class="fa fa-rub"></i>
						</p>
						<p class="field field_opening-cash">
							<b><?=$model->getAttributeLabel('OPENING_TIME')?>
								: </b> <?=date('d.m.Y H:i:s', strtotime($model->OPENING_TIME))?>
						</p><?
						if( $intClosingTime > 0 ){
							?><p class="field field_opening-cash">
							<b><?=$model->getAttributeLabel('CLOSING_TIME')?>
								:
							</b>
							<?=date('d.m.Y H:i:s', strtotime($model->CLOSING_TIME))?>
							</p><?
						}
						elseif( $intClosingTime < 0 ){
							?><div class="cash-period__buttons">
								<a href="/admin/cash-periods/close/?id=<?=$model->ID?>" class="btn btn-primary js-ajax-link">Закрыть смену</a>
							</div><?
						}
						?>
					</div>
				</div>
			</div>
			<div id="tab-2" class="tab-pane">
				<?= $this->render('operations', [
					'arMoneyMovements' => $arMoneyMovements,
					'arUsers' => $arUsers
				]) ?>
			</div>
		</div>
	</div>

</div>