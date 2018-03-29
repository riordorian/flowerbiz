<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MoneyAccounts */

$this->title = 'Обновление счета: ' . $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Счета', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NAME, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="money-accounts-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
