<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LoyaltyPrograms */

$this->title = 'Update Loyalty Programs: ' . $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Loyalty Programs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NAME, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="loyalty-programs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
