<? /* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Терминал';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="terminal__calendar-wrap">
	<div id="calendar" class="js-widget fullcalendar terminal__calendar space-20" data-orders='<?=json_encode($arOrders)?>'></div>

	<div class="terminal__sidebar">
		<div class="terminal__sidebar-inner js-terminal__sidebar"></div>
	</div>
</div>
<?//= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-primary btn-lg btn-circle btn-add']) ?>
