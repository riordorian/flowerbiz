<?$intClosingTime = strtotime($model->CLOSING_TIME);

?><div class="cash-period" data-cashbox-id="<?=$model->ID?>">
	<div class="cash-period__inner">
		<h2>
			<a href="/admin/cash-periods/view/?id=<?=$model->ID?>" class="js-widget popup link">Смена <?=$model->ID?>
				<i class="m-l fa <?=( $intClosingTime < 0 ) ? 'fa-unlock' : 'fa-lock'?>"></i></a>
		</h2>
		<div class="cash-period__info">
			<p class="field field_user">
				<b>Ответственный: </b> <?=$model->USER_NAME?>
			</p>
			<p class="field field_opening-cash">
				<b><?=$model->getAttributeLabel('CASHBOX_ID')?>: </b> <?=$model->cashbox->NAME?>
			</p>
			<p class="field field_opening-cash">
				<b><?=$model->getAttributeLabel('OPENING_TIME')?>
					: </b> <?=date('d.m.Y H:i:s', strtotime($model->OPENING_TIME))?>
			</p><?
			if( $intClosingTime > 0 ) {
				?><p class="field field_opening-cash">
					<b><?=$model->getAttributeLabel('CLOSING_TIME')?>
						: </b>
					<?=date('d.m.Y H:i:s', strtotime($model->CLOSING_TIME))?>
				</p><?
			}
			elseif( $intClosingTime < 0 ) {
				?><div class="cash-period__buttons">
					<a href="/admin/cash-periods/close/?id=<?=$model->ID?>" class="btn btn-primary js-ajax-link">
						Закрыть смену
					</a>
				</div><?
			}
			?>
		</div>
	</div>
</div>