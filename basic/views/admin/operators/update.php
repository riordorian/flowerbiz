<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Clients */

$this->title = 'Обновление данных флориста: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';

?><div class="clients-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
