<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EventsTypes */

$this->title = 'Обновление типа получателей: ' . $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Типы получателей', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NAME, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="events-types-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
