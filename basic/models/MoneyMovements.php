<?php

namespace app\models;

use budyaga\users\models\User;
use Yii;
use yii\base\Exception;
use yii\db\Transaction;

/**
 * This is the model class for table "money_movements".
 *
 * @property integer $ID
 * @property string $NAME
 * @property integer $TYPE
 * @property integer $AMOUNT
 * @property integer $MONEY_ACCOUNT
 * @property integer $ORDER_ID
 * @property integer $CASHBOX_ID
 * @property integer $USER_ID
 * @property string $DATE
 * @property string $COMMENT
 */
class MoneyMovements extends Prototype
{
    public $obTransaction;


    /**
     * Operations types array
     *
     * @var array
     */
    public $arOpTypes = [
        'INCOME' => 'Доход',
        'CONSUMPTION' => 'Расход',
//        'TRANSFER' => 'Перевод',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'money_movements';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME', 'TYPE', 'AMOUNT', 'MONEY_ACCOUNT', 'DATE', 'USER_ID'], 'required'],
            [['AMOUNT', 'MONEY_ACCOUNT', 'MONEY_ACCOUNT_FROM', 'ORDER_ID', 'USER_ID', 'CASHBOX_ID'], 'integer'],
            [['DATE'], 'safe'],
            [['COMMENT'], 'string'],
            [['NAME'], 'string', 'max' => 50],
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
            'TYPE' => 'Тип',
            'AMOUNT' => 'Сумма',
            'MONEY_ACCOUNT' => 'На счет',
            'MONEY_ACCOUNT_FROM' => 'Счет',
            'ORDER_ID' => 'ID заказа',
            'DATE' => 'Дата операции',
            'COMMENT' => 'Комментарий',
            'USER_ID' => 'Ответственный за операцию',
            'CASHBOX_ID' => 'Касса',
        ];
    }


    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $arPost = Yii::$app->request->post();
        if( $this->load($arPost) ){
            $arAttrs = $this->getAttributes();

            /*if( $this->isNewRecord && $arPost['RELOADED'] == 1 ){
                */?><!--<pre><?/*print_r(123)*/?></pre>--><?/*
                return true;
            }*/

            # Creating name
            if( !empty($arAttrs['DATE']) && !empty($arAttrs['TYPE']) && empty($arAttrs['NAME']) ){
                $this->NAME = $this->arOpTypes[$arAttrs['TYPE']] . ' ' . $arAttrs['DATE'];
            }
            elseif( !empty($arAttrs['NAME']) ){
                $arName = explode(' ', $arAttrs['NAME']);
                $this->NAME = $this->arOpTypes[$arAttrs['TYPE']] . ' ' . implode(' ', array_slice($arName, 1));
            }

            # Set operation user
            $this->USER_ID = Yii::$app->user->id;

            # Formatting date
            $this->DATE = date('Y-m-d H:i:s', strtotime($arAttrs['DATE']));
        }

        return parent::beforeValidate();
    }


/**
     * Making
     * Transactions
     * Formatting dates
     *
     * @param bool $insert - fields for inserting
     *
     * @return bool
     */
    public function beforeSave($insert) {
        if( parent::beforeSave($insert) ){
            $obConnection = Yii::$app->db;
            $this->obTransaction = $obConnection->getTransaction();
            
            if( empty($this->obTransaction) ){
                $this->obTransaction = $obConnection->beginTransaction();
                $bTransitTransaction = false;
            }
            else{
                $bTransitTransaction = true;
            }
            
            $arAttrs = $this->getAttributes();
            $newAccount = $arAttrs['MONEY_ACCOUNT'];
            $operationType = $arAttrs['TYPE'];
            $newAmount = $arAttrs['AMOUNT'] * (( $operationType == 'CONSUMPTION' ) ? -1 : 1);
            $obMoneyAccount = MoneyAccounts::findOne($newAccount);

            $cashBoxId = $obMoneyAccount->TYPE == 'CASH' ? $arAttrs['CASHBOX_ID'] : 0;

            if( $this->isNewRecord === false ){
                $arOldAttrs = $this->getOldAttributes();
                $oldAmount = $arOldAttrs['AMOUNT'] * (( $operationType == 'CONSUMPTION' ) ? -1 : 1);
                $oldAccount = $arOldAttrs['MONEY_ACCOUNT'];

                # If we changed operation type or money account but amounts differenсe is 0
                $newAmount = $newAmount - $oldAmount;
                if( $newAmount == 0 && !empty($oldAmount)
                    && ($oldAccount != $newAccount || $operationType != $arOldAttrs['TYPE'] ) ){
                    $newAmount = $oldAmount;
                }

                try{
                    if( $oldAccount == $arAttrs['MONEY_ACCOUNT'] ){
                        $obMoneyAccount->makeTransaction($newAmount, $cashBoxId);
                    }
                    else{
                        $obOldMoneyAccount = MoneyAccounts::findOne($oldAccount, $cashBoxId);
                        $obOldMoneyAccount->makeTransaction(-$oldAmount, $cashBoxId);
                        $obMoneyAccount->makeTransaction($newAmount, $cashBoxId);
                    }

                    if( $bTransitTransaction !== true ){
                        $this->obTransaction->commit();
                    }

                    return true;
                }
                catch(\Exception $e){
                    $this->addError('AMOUNT', $e->getMessage());
                    if( $bTransitTransaction !== true ){
                        $this->obTransaction->rollBack();
                    }
                }

            }
            else{
                try{
                    $obMoneyAccount->makeTransaction($newAmount, $cashBoxId);
                    if( $bTransitTransaction !== true ){
                        $this->obTransaction->commit();
                    }
                    
                    return true;
                }
                catch(Exception $e){
                    $this->addError('AMOUNT', $e->getMessage());
                    if( $bTransitTransaction !== true ){
                        $this->obTransaction->rollBack();
                    }
                }
            }
        }

        return false;
    }

/**
     * Relation with moneyAccounts
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMoneyAccount()
    {
        return $this->hasOne(MoneyAccounts::className(), ['ID' => 'MONEY_ACCOUNT']);
    }

        /**
         * Relation with moneyAccounts
         *
         * @return \yii\db\ActiveQuery
         */
        public function getUser()
        {
            return $this->hasOne(User::className(), ['id' => 'USER_ID'])->inverseOf('moneyMovements');
        }
}
