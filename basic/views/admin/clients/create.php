<?

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Clients */

$this->title = 'Добавление нового клиента';
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-create">
    <?= $this->render('_form', [
        'model' => $model,
        'modelCTypes' => $modelCTypes,
        'modelCCTypes' => $modelCCTypes,
        'modelCCGroups' => $modelCCGroups,
        'arCTypes' => $arCTypes,
        'arCGroups' => $arCGroups,
        'bDefCTypeChecked' => $bDefCTypeChecked,
        'nameLabel' => $nameLabel,
    ]) ?>
</div>