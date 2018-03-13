<?php

namespace app\models;

use app\models\User;
use Yii;
use yii\web\Request;

/**
 * This is the model class for table "cashperiods".
 *
 * @property integer $ID
 * @property string $OPENING_TIME
 * @property string $CLOSING_TIME
 * @property double $OPENING_CASH
 * @property double $CURRENT_CASH
 * @property integer $CASHBOX_ID
 * @property integer $USER_ID
 * @property integer $USER_NAME
 * @property integer $CASH_INCOMES
 *
 * @property Cashboxes $CASHBOX
 * @property User $USER
 */
class Cashperiods extends Prototype
{
    public $USER_NAME;

    /**
     * @var cash incomes
     */
    public $CASH_INCOMES;

    /**
     * @var card incomes
     */
    public $CARDS_INCOMES;
    public $LAST_PERIOD_CASH;
    public $CASH_DIFFERENCE;
    public $OPERATION_DIFFERENCE;
    public $MAKE_TRANSACTION;
    protected $obTransaction;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cashperiods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['OPENING_TIME', 'OPENING_CASH', 'CASHBOX_ID', 'USER_ID'], 'required', 'message' => 'Поле {attribute} заполнено некорректно'],
            [['OPENING_TIME', 'CLOSING_TIME'], 'safe'],
            [['OPENING_CASH', 'CURRENT_CASH'], 'number', 'message' => 'Поле {attribute} заполнено некорректно'],
            [['CASHBOX_ID', 'USER_ID'], 'integer'],
            [['CASHBOX_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Cashboxes::className(), 'targetAttribute' => ['CASHBOX_ID' => 'ID']],
            [['USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['USER_ID' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID смены',
            'OPENING_TIME' => 'Время открытия',
            'CLOSING_TIME' => 'Время закрытия',
            'OPENING_CASH' => 'Денег на момент открытия',
            'CURRENT_CASH' => 'Денег на текущий момент',
            'CASHBOX_ID' => 'Касса',
            'USER_ID' => 'Ответственный за смену',
            'PROFIT' => 'Выручка',
            'CASH_PROFIT' => 'Выручка наличными',
            'CARDS_PROFIT' => 'Выручка по терминалу',
            'LAST_PERIOD_CASH' => 'Расчетная сумма в кассе: #SUMM# <i class="fa fa-rub"></i>',
            'CASH_DIFFERENCE' => 'Расхождение по кассе: #SUMM# <i class="fa fa-rub"></i>',
            'DIFFERENCE_OPERATION' => 'Будет создана #TYPE# операция на сумму: #SUMM# <i class="fa fa-rub"></i>',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCashbox()
    {
        return $this->hasOne(Cashboxes::className(), ['ID' => 'CASHBOX_ID'])->inverseOf('cashperiods');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'USER_ID'])->inverseOf('cashperiods');
    }


    /**
     * Preparing fields
     * 
     * @return bool
     */
    public function beforeValidate()
    {
        $arPost = Yii::$app->request->post();
        if( $this->load($arPost) ) {

            # Formatting opening time
            if( empty($this->OPENING_TIME) ){
                $this->OPENING_TIME = date('Y-m-d H:i:s');
            }

            # Set user id
            if( empty($this->USER_ID) ){
                $this->USER_ID = Yii::$app->user->id;
            }

        }

        return parent::beforeValidate();
    }


    /**
     * Getting open periods
     * 
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getOpenedPeriods()
    {
        return Cashperiods::find()->select(['ID', 'CURRENT_CASH', 'OPENING_TIME', 'CLOSING_TIME'])
            ->andWhere(['<', 'OPENING_TIME', date('Y-m-d H:i:s')])
            ->andWhere(['=', 'CLOSING_TIME', '0000-00-00 00:00:00'])
            ->asArray()
            ->all();
    }


    /**
     * After save elem handler
     * 
     * @param bool $insert
     *
     * @return bool
     * @throws \yii\db\Exception
     */
    public function beforeSave($insert)
    {
        $arPost = Yii::$app->request->post();
        $obConnection = Yii::$app->db;
        $this->obTransaction = $obConnection->beginTransaction();

        if( $insert ){
            $this->CURRENT_CASH = $this->OPENING_CASH;
        }

        # throw error if current opening cash not equals to last cash periods closing cash
        if( $insert ){
            $arLastPeriod = Cashperiods::find()->select(['CURRENT_CASH', 'CLOSING_TIME'])
                ->where(['CASHBOX_ID' => $this->CASHBOX_ID, ])
                ->andWhere(['<', 'OPENING_TIME', date('Y-m-d H:i:s')])
                ->addOrderBy(['ID' => SORT_DESC])
                ->asArray()->one();

            if( strtotime($arLastPeriod['CLOSING_TIME']) < 0 ){
                $this->addError('CASHBOX_ID', 'Закройте предыдущую смену по данной кассе');
                $this->obTransaction->rollBack();
                return false;
            }

            $difference = $this->CASH_DIFFERENCE = $this->OPENING_CASH - $arLastPeriod['CURRENT_CASH'];
            if( $this->OPENING_CASH != $arLastPeriod['CURRENT_CASH']
                && empty($arPost['Cashperiods']['MAKE_TRANSACTION'])
                || (!empty($arPost['Cashperiods']['TRANSACTION_AMOUNT']) && !empty($this->CASH_DIFFERENCE)
                    && $arPost['Cashperiods']['TRANSACTION_AMOUNT'] != $difference)  ){

                $this->addError('LAST_PERIOD_CASH', str_replace('#SUMM#', $arLastPeriod['CURRENT_CASH'],$this->getAttributeLabel('LAST_PERIOD_CASH')) );
                $this->addError('CASH_DIFFERENCE', str_replace('#SUMM#', $difference, $this->getAttributeLabel('CASH_DIFFERENCE')) );
                $this->addError('DIFFERENCE_OPERATION', str_replace(['#TYPE#', '#SUMM#'], [$difference < 0 ? 'расходная' : 'приходная', $difference], $this->getAttributeLabel('DIFFERENCE_OPERATION')) );
                $this->obTransaction->rollBack();
                return false;
            }
        }
        
        return parent::beforeSave($insert);
    }


    /**
     * @param bool  $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        $arPost = Yii::$app->request->post();
        
        /**
         * If there some cash difference during opening cash period
         */
        if( !empty($arPost['Cashperiods']['TRANSACTION_AMOUNT']) && !empty($arPost['Cashperiods']['MAKE_TRANSACTION']) && $insert ){
            $arCashAccId = MoneyAccounts::find(['TYPE' => 'CASH'])->select(['ID'])->asArray()->one();
            $cashAccId = reset($arCashAccId);
            try{
                $obMM = new MoneyMovements();
                $obMM->attributes = [
                    'CASHBOX_ID' => $this->CASHBOX_ID,
                    'AMOUNT' => abs($arPost['Cashperiods']['TRANSACTION_AMOUNT']),
                    'TYPE' => $arPost['Cashperiods']['TRANSACTION_AMOUNT'] < 0 ? 'CONSUMPTION' : 'INCOME',
                    'MONEY_ACCOUNT' => $cashAccId,
                    'USER_ID' => $this->USER_ID,
                    'DATE' => date('Y-m-d H:i:s'),
                    'NAME' => ($arPost['Cashperiods']['TRANSACTION_AMOUNT'] < 0 ? 'Расход ' : 'Доход ') . date('d.m.Y H:i:s'),
                    'COMMENT' => 'Автоматическая операция. Открытие смены ' . $this->ID,
                ];

                
                if( $obMM->save(false) ){
                    $this->obTransaction->commit();
                    unset($this->obTransaction);
                }
            }
            catch(\Exception $e){
                $this->obTransaction->rollBack();
                unset($this->obTransaction);
            }
        }

        if( !empty($this->obTransaction) ){
            $this->obTransaction->commit();
        }

        parent::afterSave($insert, $changedAttributes);
    }


    /**
     *
     */
    public function afterFind()
    {
        try{
            # Find user name by user id
            $arUsername = User::find()->where(['id' => $this->USER_ID])->select('username')->one()->toArray();
            $this->USER_NAME = $arUsername['username'];
        }
        catch(\Exception $e){
            Yii::trace($e);
        }

        return parent::afterFind();
    }


    /**
     * Getting cash period operations
     * 
     * @param $cashBoxId - cashbox id
     * @param $closingTime - time of closing CB
     * @param $openingTime - time of opening CB
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getCashPeriodOperations($cashBoxId, $closingTime, $openingTime)
    {

        if( empty($cashBoxId) || empty($closingTime) || empty($openingTime) ){
            return [];
        }
        
        $rsMMovements = $arMMovements = MoneyMovements::find()->where([
            'CASHBOX_ID' => $cashBoxId,
        ]);
        $closingTimeStamp = strtotime($closingTime);
        if( $closingTimeStamp < 0 ){
            $rsMMovements->andWhere(['>=', 'DATE', $openingTime]);
        }
        else{
            $rsMMovements->andWhere(['between', 'DATE', $openingTime, $closingTime]);
        }
        
        return $rsMMovements->all();
    }
}
