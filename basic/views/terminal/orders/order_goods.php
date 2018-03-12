<? use yii\grid\GridView; ?>

<div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12 white-bg p-sm">

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'summary' => false,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'good.NAME',
			[
				'attribute' => 'good.IMAGE',
				'format' => ['image',['height'=>'50']],
			],
			'AMOUNT'
		],
		'tableOptions' => [
			'class' => 'table table-striped'
		],
	]);?>

</div>