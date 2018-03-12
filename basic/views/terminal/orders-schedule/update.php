<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\OrdersSchedule */

$this->title = 'Обновление заказа №' . $model->ID;
?><div class="orders-schedule-create js-ajax-replaceable white-bg p-sm">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'arRecipients' => $arRecipients,
        'arEvents' => $arEvents
    ]) ?>

</div>
