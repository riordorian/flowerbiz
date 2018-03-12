<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\GoodSupply */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Списания товара'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="good-supply-view">

    <p>
        <?= Html::a(Yii::t('app', 'Изменить'), ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы уверены, что хотите удалить списание?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            [
                'attribute' => 'DATE',
                'label' => 'Дата списания'
            ]
        ],
    ]) ?>

</div>
