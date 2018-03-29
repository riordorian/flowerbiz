<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MoneyMovements */

/*$this->title = 'Добавление операции';
$this->params['breadcrumbs'][] = ['label' => 'Операции', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>

<?= $this->render('_form', [
    'model' => $model,
    'arTypes' => $arTypes,
]) ?>