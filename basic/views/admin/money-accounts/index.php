<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MoneyAccountsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Счета';
$this->params['breadcrumbs'][] = $this->title;
$arReq = Yii::$app->request->queryParams;

?><div class="money-accounts-index">
    <? // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-primary btn-lg btn-circle btn-add']) ?>
    </p><?

    if( !empty($arReq['DELETE_ERROR']) && $arReq['DELETE_ERROR'] == 'Y' ){
        ?><div class="alert alert-danger">Невозможно удалить счет. По данному счету были проведены операции</div><?
    }


Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
                        case 'BONUS':
                            $type = 'Бонусы';
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

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'text-right column column_actions'],
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        $customurl = Yii::$app->getUrlManager()->createUrl(['admin/money-accounts/update','id' => $model['ID']]);
                        if( !in_array($model['TYPE'], ['CASH', 'BONUS']) ){
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                                ['title' => Yii::t('yii', 'Edit'), 'data-pjax' => '0']);
                        }
                    },
                    'delete'=>function ($url, $model) {
                        $customurl = Yii::$app->getUrlManager()->createUrl(['admin/money-accounts/delete','id' => $model['ID']]);
						if( !in_array($model['TYPE'], ['CASH', 'BONUS']) ){
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>', $customurl,
                                ['title' => Yii::t('yii', 'Delete'), 'data-pjax' => '0']);
                        }
                    }
                ],
            ],
        ],
        'tableOptions' => [
            'class' => 'table table-striped'
        ]
    ]); ?>
<?php Pjax::end(); ?></div>
