<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Clients */

$this->title = 'Обновление данных клиента: ' . $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NAME, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Обновление';

?><div class="clients-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelCTypes' => $modelCTypes,
        'modelCCTypes' => $modelCCTypes,
        'modelCCGroups' => $modelCCGroups,
        'modelCEvents' => $modelCEvents,
        'arModelCEvents' => $arModelCEvents,
        'arCTypes' => $arCTypes,
        'arCGroups' => $arCGroups,
        'arEvents' => $arEvents,
        'arRecipients' => $arRecipients,
        'bDefCTypeChecked' => $bDefCTypeChecked,
        'nameLabel' => $nameLabel,
    ]) ?>

</div>
