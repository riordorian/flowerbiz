<?

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Clients */

$this->title = 'Добавление нового администратора';
$this->params['breadcrumbs'][] = ['label' => 'Администраторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>