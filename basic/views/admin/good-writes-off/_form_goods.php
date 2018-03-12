<?

use app\models\Utils;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GoodSupply */
/* @var $form yii\widgets\ActiveForm */
?><div class="clearfix"><?
    $form = ActiveForm::begin([
        'method' => 'post',
        'options' => [
            'data-entity' => 'events'
        ]
    ]);?>

    <? if( !empty($modelGoodsSupplies->ID) ){
        echo $form->field(
            $modelGoodsSupplies,
            'ID'
        )->hiddenInput(['value' => $modelGoodsSupplies->ID])->label(false);
    }?>

    <?
        echo $form->field(
            $modelGoodsSupplies,
            'GOOD_SUPPLY_ID'
        )->hiddenInput(['value' => $model->ID])->label(false);
    ?>

    <?= $form->field(
        $modelGoodsSupplies,
        'GOOD_ID',
        ['options' => ['class' => 'col-md-4']]
    )->dropDownList($arGoods, ['prompt' => 'Выберите товар', 'class' => 'js-widget chosen', 'data-config' => json_encode(['disable_search' => false])]);?>

    <?
    echo $form->field(
        $modelGoodsSupplies,
        'AMOUNT',
        ['options' => ['class' => 'col-md-4']]
    )->textInput(['value' => $modelGoodsSupplies->AMOUNT ? $modelGoodsSupplies->AMOUNT : 1, 'type' => 'number' ]);
    ?>

    <?

    if( !empty($modelGoodsSupplies->ID) ){

        ?><div class="column_actions p-h-xxs">
        <label for="">&nbsp;</label><br>
        <a href="/admin/clients-events/delete/" class="js-link_del" data-row-id="<?=$modelGoodsSupplies->ID?>">
            <i class="fa fa-times"></i>
        </a>
        </div><?
    }


    ActiveForm::end();
?></div>