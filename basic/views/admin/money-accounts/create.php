<?

/* @var $this yii\web\View */
/* @var $model app\models\MoneyAccounts */

$this->title = 'Добавление счета';
$this->params['breadcrumbs'][] = ['label' => 'Счета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?><div class="money-accounts-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
