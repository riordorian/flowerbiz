<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LoyaltyPrograms */

$this->title = 'Программы лояльности';
$this->params['breadcrumbs'][] = ['label' => 'Программы лояльности', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?><div class="loyalty-programs-create">
    <?= $this->render('_form', [
        'arModels' => $arModels,
        'arModelSteps' => $arModelSteps,
        'modelSteps' => $modelSteps,
        'arGroups' => $arGroups,
    ]) ?>
</div>