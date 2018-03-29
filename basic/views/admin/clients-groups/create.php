<?

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ClientsGroups */

$this->title = 'Создание группы клиентов';
$this->params['breadcrumbs'][] = ['label' => 'Группы клиентов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-groups-create">

    <?= $this->render('_form', [
        'model' => $model,
        'arLoyalties' => $arLoyalties
    ]) ?>

</div>
