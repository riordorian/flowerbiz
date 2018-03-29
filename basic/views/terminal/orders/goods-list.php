<!--TODO: Сделать выравнивание блоков по высоте, если отличаются названия-->
<? if( count($arGoods) > 2 ){
	?><p class="text-center m-b-lg clearfix">
		<a href="javascript:;" class="js-all-goods link btn btn-md btn-primary">Все товары</a>
	</p><?
}

foreach($arGoods as $arGood){
	echo $this->render('_good', [
		'arGood' => $arGood
	]);
}

?>

<span class="clearfix"></span>
<p class="text-center m-t-lg">
	<a href="javascript:;" class="js-all-goods link btn btn-md btn-primary">Все товары</a>
</p>
