<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MoneyAccounts */

$this->title = $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Счета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-accounts-view"><?
    if( $model->TYPE != 'CASH' ){
        ?><p>
            <?= Html::a('Обновить', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        
            <?= Html::a('Удалить', ['delete', 'id' => $model->ID], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить счет?',
                    'method' => 'post',
                ],
            ]) ?>
        </p><?
    }
    ?>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'NAME',
            [
                'attribute' => 'TYPE',
                'value' => function ($dataProvider) {
                    switch($dataProvider->TYPE){
                        case 'CASH':
                            $type = 'Наличные';
                            break;
                        case 'CARD':
                            $type = 'Банковская карта';
                            break;
                        case 'BANK_ACCOUNT':
                            $type = 'Банковский счет';
                            break;
                    }

                    return $type;
                },
            ],
            [
                'attribute' => 'BALANCE',
                'value' => function ($dataProvider) {
                    return number_format($dataProvider->BALANCE, 0, '.', ' ') . ' <i class="fa fa-rub"></i>';
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'USE_ON_CASHBOX',
                'value' => function ($dataProvider) {
                    return $dataProvider->USE_ON_CASHBOX ? 'Да' : 'Нет';
                },
            ],
        ],
    ]) ?>

</div>
