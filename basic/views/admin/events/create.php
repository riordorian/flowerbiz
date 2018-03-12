<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EventsTypes */

$this->title = 'Добавление типа событий';
$this->params['breadcrumbs'][] = ['label' => 'Типы событий', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-types-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
