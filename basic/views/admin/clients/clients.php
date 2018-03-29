<?

/* @var $this yii\web\View */

use app\models\Clients;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;

echo GridView::widget([
    'dataProvider' => $dataProvider,

    'tableOptions' => [
        'class' => 'clients table table-striped dataTable'
    ],

    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
        ],
        [
            'attribute' => 'NAME',
            'label' => 'ФИО',
        ],
        [
            'attribute' => 'PHONE',
            'label' => 'Телефон',
        ],
        [
            'attribute' => 'NAME',
            'value' => 'cg.NAME',
            'label' => 'Группа',
        ]
    ],

    'summary' => 'Показано {count} из {totalCount}',
    'layout' => "{items}\n{pager}",
    'pager' => [
        'firstPageLabel' => 'Первая',
        'lastPageLabel' => 'Последняя',
        'nextPageLabel' => 'Следующая',
        'prevPageLabel' => 'Предыдущая',
        'maxButtonCount' => 5,
    ],
]);