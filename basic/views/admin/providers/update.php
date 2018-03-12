<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Providers */

$this->title = 'Обновление поставщика: ' . $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Поставщики', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NAME, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="clients-types-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
