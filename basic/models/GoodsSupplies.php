<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "goods_supplies".
 *
 * @property integer $ID
 * @property integer $GOOD_SUPPLY_ID
 * @property integer $GOOD_ID
 * @property integer $AMOUNT
 * @property double $PRICE
 *
 * @property CATALOGPRODUCTS $gOOD
 */
class GoodsSupplies extends Prototype
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_supplies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GOOD_SUPPLY_ID', 'GOOD_ID', 'AMOUNT'], 'required'],
            [['GOOD_SUPPLY_ID', 'GOOD_ID', 'AMOUNT'], 'integer'],
            [['PRICE'], 'number'],
            [['GOOD_SUPPLY_ID'], 'exist', 'skipOnError' => true, 'targetClass' => GoodSupply::className(), 'targetAttribute' => ['GOOD_SUPPLY_ID' => 'ID']],
            [['GOOD_ID'], 'exist', 'skipOnError' => true, 'targetClass' => CATALOGPRODUCTS::className(), 'targetAttribute' => ['GOOD_ID' => 'ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'GOOD_SUPPLY_ID' => 'Поставка',
            'GOOD_ID' => 'Товар',
            'AMOUNT' => 'Количество',
            'PRICE' => 'Цена',
        ];
    }


    /**
     * @return $this
     */
    public function getGoodSupply()
    {
        return $this->hasOne(GoodSupply::className(), ['ID' => 'GOOD_SUPPLY_ID'])->inverseOf('goodsSupplies');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasOne(CATALOGPRODUCTS::className(), ['ID' => 'GOOD_ID'])->inverseOf('goodsSupplies');
    }


    /**
     * Bind good to supply
     * @param $goodSupply
     * @param $goodId
     * @param $amount
     *
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function addGood($goodSupply, $goodId, $amount)
    {
        if( empty($goodSupply) || empty($goodId) || empty($amount) ){
            throw new \Exception('Incorrect params');
        }

        $modelGoodsSupplies = new GoodsSupplies();
        $modelCExGoodS = $this->find()->where([
            'GOOD_SUPPLY_ID' => $goodSupply,
            'GOOD_ID' => $goodId,
        ])->one();

        if( !empty($modelCExGoodS->ID) ){
            if( $amount != $modelCExGoodS->getAttribute('AMOUNT') ){
                $goodAmountDiff = $amount > 0 ? $amount - $modelCExGoodS->getAttribute('AMOUNT') : $amount + $modelCExGoodS->getAttribute('AMOUNT');
            }
            else{
                $goodAmountDiff = 0;
            }

            $modelCExGoodS->setAttributes([
                'GOOD_SUPPLY_ID' => $goodSupply,
                'GOOD_ID' => $goodId,
                'AMOUNT' => $amount,
            ]);
            $modelGoodsSupplies = $modelCExGoodS;
        }
        else{
            $goodAmountDiff = $amount;
        }

        $obConnection = Yii::$app->db;
        $obTransaction = $obConnection->beginTransaction();
        if( $modelGoodsSupplies->save(true) ){
            $obGood = CatalogProducts::find()->where(['ID' => $goodId])->one();
            $obGood->setAttribute('AMOUNT', $obGood->getAttribute('AMOUNT') + $goodAmountDiff);

            if( $obGood->save(true) ){
                $obTransaction->commit();
            }
            else{
                $obGood->getErrors();
                $obTransaction->rollBack();
            }
        }
        else{
            $obTransaction->rollBack();
        }
    }
}
