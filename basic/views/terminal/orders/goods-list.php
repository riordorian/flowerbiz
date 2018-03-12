<!--TODO: Сделать выравнивание блоков по высоте, если отличаются названия-->
<?
foreach($arGoods as $arGood){
	echo $this->render('_good', [
		'arGood' => $arGood
	]);
}

?>

<div class="clearfix"></div>
<div class="text-center m-t-lg">
	<a href="javascript:;" class="js-all-goods link btn btn-md btn-primary">Все товары</a>
</div>
