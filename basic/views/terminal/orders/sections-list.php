

<? foreach($arSections as $arSection){
	echo $this->render('_category', [
		'arCategory' => $arSection
	]);
}