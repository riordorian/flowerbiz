<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ClientsTypes */

$this->title = $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Типы клиентов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-types-view">

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить тип клиента?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'NAME',
        ],
    ]) ?>

</div>
