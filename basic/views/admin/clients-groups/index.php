<?

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientsGroupsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Группы клиентов';
$this->params['breadcrumbs'][] = $this->title;

?><div class="clients-groups-index">

    <?  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-primary btn-lg btn-circle btn-add']) ?>
    </p>

    <div class="js-replaceable-container"><?
        Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'NAME',
                'PERCENT',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['class' => 'text-right column column_actions']
                ],
                [
                    'attribute' => 'LOYALTY_PROGRAM',
                    'value' => 'loyaltyPrograms.NAME',
                ],
            ],
            'tableOptions' => [
                'class' => 'table table-striped'
            ],
        ]);
        Pjax::end();
    ?></div>
</div>
