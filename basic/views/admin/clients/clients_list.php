<? use yii\helpers\Html;

$arResult = $model->getAttributes();
?>

<tr class="clients__item"><?
	foreach($arResult as $k => $propVal) {
		?><div><?=Html::encode($propVal)?></div><?
	}
?></tr>