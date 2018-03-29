<?php

namespace app\models;

use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "money_accounts".
 *
 * @property integer $ID
 * @property string $NAME
 * @property double $BALANCE
 */
class MoneyAccounts extends Prototype
{
    protected $obTransaction;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'money_accounts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME', 'TYPE', 'USE_ON_CASHBOX'], 'required'],
            [['BALANCE'], 'number'],
            [['USE_ON_CASHBOX'], 'integer'],
            [['NAME'], 'string', 'max' => 75],
            [['TYPE'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NAME' => 'Название',
            'TYPE' => 'Тип счета',
            'BALANCE' => 'Баланс',
            'USE_ON_CASHBOX' => 'Используется на кассе',
        ];
    }


    /**
     * Making transaction
     *
     * @param $amount
     * @param $cashBoxId
     *
     * @return bool
     * @throws Exception
     * @throws \Exception
     */
    public function makeTransaction($amount, $cashBoxId = 0)
    {
        $amount = intval($amount);

        if( !isset($amount) || $amount == 0 ){
            throw new \Exception('Incorrect operation sum');
        }

        $obConnection = Yii::$app->db;
        $this->obTransaction = $obConnection->getTransaction();
        if( empty($this->obTransaction) ){
            $this->obTransaction = $obConnection->beginTransaction();
        }
        else{
            $bTransitTransaction = true;
        }
        
        if( $amount > 0 ){
            $bDone = $this->addIncome($amount);
        }
        elseif( $amount < 0 ){
            $bDone = $this->addConsumption($amount);
        }

        if( $bDone && !empty($cashBoxId) ){
            $obCashBox = Cashboxes::find(['ID' => $cashBoxId])->one();
            $obCashBox->setAttribute('SUMM', $obCashBox->getAttribute('SUMM') + $amount);
            if( $bDone = $obCashBox->save() ){
                if( $bTransitTransaction !== true ){
                    $this->obTransaction->commit();
                }

                return true;
            }

            if( $bTransitTransaction !== true ){
                $this->obTransaction->rollBack();
            }

            return false;
        }
        else{
            if( $bTransitTransaction !== true ){
                $this->obTransaction->rollBack();
            }

            return false;
        }
    }



    /**
     * Adding a consumption
     *
     * @param $amount - negative money amount
     *
     * @return bool
     * @throws Exception
     */
    private function addConsumption($amount)
    {
        if( empty($amount) ){
            return false;
        }

        # Disabling a negative balance
        if( $this->BALANCE + $amount >= 0 ){
            return $this->updateCounters(['BALANCE' => $amount]);
        }
        else{
            throw new Exception('Суммы на счете недостаточно для совершения операции. (На счете ' . $this->NAME . ' доступно средств: ' . $this->BALANCE . 'руб.)');
        }
    }


    /**
     * Adding income
     *
     * @param $amount - money amount
     *
     * @return bool
     */

    /**
     * Adding income
     * 
     * @param $amount - money amount
     *
     * @return bool
     */
    private function addIncome($amount)
    {
        if( empty($amount) ){
            return false;
        }

        return $this->updateCounters(['BALANCE' => $amount]);
    }
}
