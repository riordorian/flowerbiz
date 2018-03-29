<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Providers */

$this->title = 'Добавление нового поставщика';
$this->params['breadcrumbs'][] = ['label' => 'Поставщики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="providers-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
