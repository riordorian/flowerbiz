<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cashboxes */

$this->title = $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Кассы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cashboxes-view">

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary js-widget popup']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить данную кассу?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'NAME',
            'SUMM',
        ],
    ]) ?>

</div>
