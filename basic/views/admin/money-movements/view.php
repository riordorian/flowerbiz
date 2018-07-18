<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MoneyMovements */

$this->title = $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Операции', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-movements-view">

    <p><?
        if( Yii::$app->user->can('moneyOperationsEdit') ){
            echo Html::a('Обновить', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary js-widget popup']);
        }

        if( Yii::$app->user->can('moneyOperationsDelete') ){
            echo Html::a('Удалить', ['delete', 'id' => $model->ID], [
                'class' => 'btn btn-danger m-l-xs',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        }

    ?></p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'NAME',
            [
                'attribute' => 'TYPE',
                'value' => function ($dataProvider) {
                    return $dataProvider->TYPE == 'INCOME' ? 'Доход' : 'Расход';
                },
            ],
			[
				'attribute' => 'ENCASHMENT',
				'value' => function ($dataProvider) {
					return $dataProvider->ENCASHMENT == 1 ? 'Да' : 'Нет';
				},
			],
            [
                'attribute' => 'AMOUNT',
                'value' => function ($dataProvider) {
                    return number_format($dataProvider->AMOUNT, 0, '.', ' ') . ' <i class="fa fa-rub"></i>';
                },
                'format' => 'html'
            ],
            'moneyAccount.NAME',
            'ORDER_ID',
            [
                'attribute' => 'DATE',
                'value' => function ($dataProvider) {
                    return date('d.m.Y H:i', strtotime($dataProvider->DATE));
                },
                'format' => 'html'
            ],
            'user.username',
            'COMMENT:ntext',
        ],
    ]) ?>

</div>
