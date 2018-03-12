<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ClientsTypes */

$this->title = 'Добавление нового типа клиентов';
$this->params['breadcrumbs'][] = ['label' => 'Типы клиентов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-types-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
