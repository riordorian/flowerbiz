<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdersScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders Schedules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-schedule-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Orders Schedule', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->ID), ['view', 'id' => $model->ID]);
        },
    ]) ?>
<?php Pjax::end(); ?></div>
