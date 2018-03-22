<?
use yii\widgets\Breadcrumbs;

$this->title = 'Все товары';
$this->params['breadcrumbs'][] = $this->title;
$arReq = Yii::$app->request->queryParams;

?><div class="terminal__orders-wrap container-fluid">
	<div class="row">
		<div class="terminal__goods col-md-8 col-sm-8 col-xs-12 space-15">
			<div class="row">
				<form class="col-md-12">
					<div class="input-group m-b">
						<input type="text" placeholder="Введите название товара" class="form-control input-lg js-find-goods">
						<span class="input-group-addon"><i class="fa fa-search"></i></span>
					</div>
				</form>


				<div class="col-md-12 m-b-lg"><?
					echo Breadcrumbs::widget([
						'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
					]);
				?></div>

				<div class="terminal__goods-box js-goods-wrap"><?
					if( empty($arCategories) ){
						?>Заведите категории товаров<?
					}
					else{
						$i = 0;
						foreach($arCategories as $arCategory){
							echo $this->render('_category.php', [
								'arCategory' => $arCategory
							]);
							$i++;
	
							if( $i % 4 == 0 ){
								?><div class="clearfix"></div> <?
							}
						}
					}
				?></div>
			</div>
		</div>

		<div class="terminal__cart col-md-4 col-sm-4 col-xs-12 js-cart" id="terminal-cart">
			<div class="terminal__moneybox-period
				text-center
				<?=( empty($arOpenedCashPeriods) || $bNeedClosePeriod && !empty($lastOpenedPeriod) ) ? '' : 'hidden'?>
				<?=( $bNeedClosePeriod && !empty($lastOpenedPeriod) ) ? 'inverse' : ''?>"
			>
				<a
					href="<?=($bNeedClosePeriod ? '/admin/cash-periods/close/?id=' . $lastOpenedPeriod : '/admin/cash-periods/open/')?>"
					class="text-navy js-ajax-link"
					<?= !$bNeedClosePeriod ? 'data-open-type="popup" data-data-type="html"' : ''?>
				>
					<i class="fa fa-lock"></i>
					<i class="fa fa-unlock-alt"></i><br>
					<span class="btn btn-primary"></span>
				</a>
			</div>
			<div class="input-group m-b-md">
				<input type="text" name="CLIENT" class="js-autocomplete-user form-control" placeholder="9998887755 или ФИО">
				<span class="input-group-btn">
					<a href="/terminal/client-add/" class="btn btn-primary js-ajax-link" data-data-type="html" data-open-type="popup">+</a>
				</span>
			</div>

			<form action="/terminal/orders/sale/">
				<label>
					<input type="checkbox" id="WORK_PAYMENT" name="WORK_PAYMENT" checked class="js-widget js-update switcher">
					<span class="m-l-sm">Учитывать работу флориста</span>
				</label>



				<div class="terminal__cart-goods js-terminal__cart-goods hidden m-b-md">
					<h3>Товары</h3>
				</div>
	

				<input type="hidden" name="OPERATORS[]" value="<?=Yii::$app->user->id?>">
				<input type="hidden" name="OPERATOR_PERCENT" class="js-operator-percent" value="<?=$arOperator['pay']?>" >
				<!--
				<h3>Флорист</h3>
				<select class="js-widget chosen" name="OPERATORS[]" multiple data-placeholder="Выберите флориста"><?/*
					foreach($arOperators as $arOperator){
						*/?><option value="<?/*=$arOperator['id']*/?>" <?/*=$arOperator['id'] == Yii::$app->user->id ? 'selected' : ''*/?>><?/*=$arOperator['username']*/?></option><?/*
					}
				*/?></select>-->
				
				<div class="js-cart-good-template m-b-xs row hidden cart-good js-cart-good">
					<div class="col-md-2 col-sm-3 col-xs-2">
						<img src="" class="img-responsive">
					</div>
					<div class="col-md-5 col-sm-3 col-xs-7">
						<p>#NAME#</p>
						<p>#PRICE# <i class="fa fa-rub"></i></p>
					</div>
					<div class="col-md-3 col-sm-4 col-xs-2">
						<input type="text" class="form-control" value="1">
	
					</div>
					<div class="col-md-2 js-remove-good text-right">
						<i class="fa fa-close"></i>
					</div>
				</div>


				<div class="js-cart-bouquet-template m-b-xs row hidden cart-good js-cart-good js-cart-bouquet">
					<div class="col-md-2 col-sm-3 col-xs-2">
						<img src="" class="img-responsive">
					</div>
					<div class="col-md-5 col-sm-3 col-xs-7">
						<p>
							#NAME#
							 (<a class="link js-ajax-link" data-data-type="html" data-open-type="popup" href="/terminal/orders/get-order-goods/?id=#ORDER_ID#">Информация</a>)
						</p>
						<p>#PRICE# <i class="fa fa-rub"></i></p>
					</div>
					<div class="col-md-3 col-sm-4 col-xs-2">
						<input type="text" class="form-control" value="1" disabled>
					</div>
					<div class="col-md-2 js-remove-good text-right">
						<i class="fa fa-close"></i>
					</div>
				</div><?

				if( !empty($arReq['COMMENT']) ){
				    ?><label for="#order-comment">Комментарий к заказу</label>
					<textarea name="ORDERS[COMMENT]" id="#order-comment" class="form-control"><?=$arReq['COMMENT']?></textarea><?
				}

				if( !empty($arReq['ORDER_ID']) ){
				    ?><input type="hidden" name="ORDER_ID" value="<?=$arReq['ORDER_ID']?>"><?
				}

				?><div class="text-center m-t-lg">
					<a class="btn btn-primary js-bouquet js-sale-link hidden" data-href="/terminal/orders/bouquet/" data-open-type="popup">Сформировать букет</a>
				</div>
	
				<div class="terminal__order-info">
					
					<div class="prices col-md-12">
						<p>
							<span>Подытог</span>
							<span class="pull-right"><span>0</span> <i class="fa fa-rub"></i></span>
							<input type="hidden" class="js-sum" name="SUM" value="0">
						</p>
						<p>
							<span>Скидка</span>
							<span class="pull-right"><span>0</span> <i class="fa fa-rub"></i></span>
							<input type="hidden" class="js-discount" name="DISCOUNT" value="0">
						</p>
						<p>
							<span>Баллы</span>
							<span class="pull-right"><span>0</span> </span>
							<input type="hidden" class="js-bonus-limit" name="BONUS" value="0">
						</p>
						<p>
							<span>Баллов за покупку</span>
							<span class="pull-right"><span>0</span> </span>
							<input type="hidden" class="js-bonus" name="BONUS" value="0">
						</p>
						<p>
							<span>Предоплата</span>
							<span class="pull-right"><span><?= empty($arOrderInfo['PREPAYMENT']) ? 0 : $arOrderInfo['PREPAYMENT']?></span> <i class="fa fa-rub"></i></span>
							<input type="hidden" class="js-prepayment" name="PREPAYMENT" value="<?= empty($arOrderInfo['PREPAYMENT']) ? 0 : $arOrderInfo['PREPAYMENT']?>">
						</p>
						
						<input type="hidden" name="CLIENT_ID" class="js-client-id-field" value="<?=empty( Yii::$app->request->queryParams['CLIENT_ID'] ) ? '' : Yii::$app->request->queryParams['CLIENT_ID']?>">
						<input type="hidden" name="OPERATOR_WORK" value="1" class="js-operator-work-field">
					</div>
					<div class="clearfix"></div>
					<div class="total js-sale-link disabled" data-href="/terminal/orders/sale/" data-open-type="popup">
						<div class="col-md-6"><b>ОПЛАТА</b></div>
						<div class="col-md-6 text-right">
							<b>
								<span>0</span> <i class="fa fa-rub"></i>
							</b>
							<input type="hidden" class="js-final-sum" name="TOTAL" value="">
						</div>
						<div class="clearfix"></div>
					</div>
				</div>

				<div class="terminal__cart-info visible-xs">
					<a class="btn btn-primary btn-rounded js-scroll-link" href="javascript:;" data-href="#terminal-cart">
						<i class="fa fa-shopping-cart"></i>
						<span class="js-cart-mobile-info m-l-sm">0</span>
						<i class="fa fa-rub"></i>
					</a>
				</div>
			</form>
		</div>

		<div class="clearfix"></div>
	</div>
</div>