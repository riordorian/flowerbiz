<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClientsGroups */

$this->title = 'Обновление группы клиентов: ' . $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Группы клиентов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NAME, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="clients-groups-update">

    <?= $this->render('_form', [
        'model' => $model,
        'arLoyalties' => $arLoyalties
    ]) ?>

</div>
