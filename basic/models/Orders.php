<?php

namespace app\models;

use app\models\User;
use Yii;

/**
 * This is the model class for table "orders_schedule".
 * This is the model class for table "orders_goods".
 *
 * @property integer $ID
 * @property integer $GOOD_ID
 * @property string $NAME
 * @property integer $CLIENT_ID
 * @property integer $GIFT_RECIPIENT_ID
 * @property integer $EVENT_ID
 * @property double $SUM
 * @property double $TOTAL
 * @property integer $DISCOUNT
 * @property string $RECEIVING_DATE_START
 * @property string $RECEIVING_DATE_END
 * @property integer $NEED_DELIVERY
 * @property string $PAYMENT_STATUS
 * @property string $TYPE
 * @property string $STATUS
 * @property double $PREPAYMENT
 * @property string $COMMENT
 *
 * @property Clients $cLIENT
 * @property Events $eVENT
 * @property GiftRecipients $gIFTRECIPIENT
 * @property OrdersGoods[] $ordersGoods
 * @property OrdersOperators[] $ordersOperators
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders_schedule';
    }
    
    public $RECEIVING_TIME_START;
    public $RECEIVING_TIME_END;
    public $CLIENT;
    public $EVENT;
    public $GIFT_RECIPIENT;
    public $OPERATOR;
    public $SUM_FORMATTED;
    public $PREPAYMENT_FORMATTED;
    public $UPLOAD;
    /**
     * @var C - collecting, F - FINISHING
     */
    public $STEP;

    /**
     * Orders types
     * P - preorder
     * W - work
     * S - sale
     * B - bouquet
     * @var array
     */
    public $arOrdersTypes = [
        'P' => [],
        'W' => [],
        'S' => [],
        'B' => [],
    ];
    /**
     * Orders statuses
     * N - not started
     * P - process
     * C - collected
     * CNC - canceled
     * D - done
     * S - shipped
     * F - finished
     * @var array
     */
    public $arStateStatuses = [
        'N' => '',
        'P' => '',
        'C' => '',
        'D' => '',
        'S' => '',
        'F' => '',
    ];
    /**
     * Orders payment statuses
     * N - not payed
     * P - payed partly
     * F - fully payed
     * W - without payment
     * @var array
     */
    public $arPayingStatuses = [
        'N' => '',
        'P' => '',
        'F' => '',
        'W' => '',
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME'], 'required'],
            [['CLIENT_ID', 'GIFT_RECIPIENT_ID', 'EVENT_ID', 'NEED_DELIVERY', 'OPERATOR_WORK'], 'integer'],
            [['TOTAL', 'PREPAYMENT', 'DISCOUNT'], 'number'],
            [['RECEIVING_DATE_START', 'RECEIVING_DATE_END', 'CLOSING_DATE', 'SELLING_TIME'], 'safe'],
            [['COMMENT', 'RECEIVING_TIME_START', 'RECEIVING_TIME_END', 'STEP'], 'string'],
            [['NAME'], 'string', 'max' => 50],
            [['STATUS'], 'string', 'max' => 3],
            [['PAYMENT_STATUS'], 'string', 'max' => 3],
            [['TYPE'], 'string', 'max' => 3],
            [['IMAGE'], 'string', 'max' => 150],
            # TODO: Не работает сохранение заказа, если не выбран клиент
            [['CLIENT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['CLIENT_ID' => 'ID']],
            [['EVENT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Events::className(), 'targetAttribute' => ['EVENT_ID' => 'ID']],
            [['GIFT_RECIPIENT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => GiftRecipients::className(), 'targetAttribute' => ['GIFT_RECIPIENT_ID' => 'ID']],
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
            'CLIENT' => 'Клиент (телефон)',
            'CLIENT_ID' => 'Клиент',
            'GIFT_RECIPIENT' => 'Получатель',
            'GIFT_RECIPIENT_ID' => 'Получатель',
            'EVENT_ID' => 'Событие',
            'EVENT' => 'Событие',
            'SUM' => 'Сумма заказа',
            'TOTAL' => 'Сумма заказа',
            'SUM_FORMATTED' => 'Сумма заказа',
            'RECEIVING_DATE_START' => 'Подготовить с',
            'RECEIVING_TIME_START' => 'Подготовить с',
            'RECEIVING_DATE_END' => 'Подготовить до',
            'RECEIVING_TIME_END' => 'Подготовить до',
            'SELLING_TIME' => 'Дата и время продажи',
            'NEED_DELIVERY' => 'Требуется доставка',
            'OPERATOR_ID' => 'Флорист',
            'OPERATOR' => 'Флорист',
            'STATUS' => 'Статус',
            'PREPAYMENT' => 'Предоплата',
            'PREPAYMENT_FORMATTED' => 'Предоплата',
            'COMMENT' => 'Комментарий',
            'IMAGE' => 'Изображение',
        ];
    }


    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $arPost = Yii::$app->request->post();

        # Setting receiving time from clockpicker
        if( $this->load($arPost) ) {
            $obDate = new \DateTime($this->RECEIVING_DATE_START);

            if( !empty($this->RECEIVING_TIME_START) ){
                $arTimeStart = explode(':', $this->RECEIVING_TIME_START);
                $obDate->setTime($arTimeStart[0], $arTimeStart[1]);
                $this->RECEIVING_DATE_START = $obDate->format('Y-m-d H:i:s');
            }
            else{
                $this->RECEIVING_DATE_START = $obDate->format('Y-m-d H:i:s');
            }

            if( !empty($this->RECEIVING_TIME_END) ){
                $arTimeEnd = explode(':', $this->RECEIVING_TIME_END);
                $obDate->setTime($arTimeEnd[0], $arTimeEnd[1]);
                $this->RECEIVING_DATE_END = $obDate->format('Y-m-d H:i:s');
            }
            else{
                $this->RECEIVING_DATE_END = $obDate->format('Y-m-d H:i:s');
            }
        }

        return parent::beforeValidate();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $arAttrs = $this->getAttributes();
        $arOldAttrs = $this->getOldAttributes();
        
        # If added new order and filled gift recipient field
        # or old gift recipient id is not equal to new gift recipient id
        # or old event id is not equal to new event id
        # and not empty event id
        # and not gift recipient id
        # then we adding new client event
        if( ($insert || $arOldAttrs['GIFT_RECIPIENT_ID'] != $arAttrs['GIFT_RECIPIENT_ID']
                || $arOldAttrs['EVENT_ID'] != $arAttrs['EVENT_ID'])
            && !empty($arAttrs['EVENT_ID']) && !empty($arAttrs['GIFT_RECIPIENT_ID']) ){
            

            $arClientEvent = ClientsEvents::find()->where([
                'CLIENT_ID' => $arAttrs['CLIENT_ID'],
                'EVENT_ID' => $arAttrs['EVENT_ID'],
                'GIFT_RECIPIENT_ID' => $arAttrs['GIFT_RECIPIENT_ID']
            ])->one();
            
            if( empty($arClientEvent) ){
                try{
                    $obCLientEvent = new ClientsEvents();
                    $obCLientEvent->setAttributes([
                        'CLIENT_ID' => $arAttrs['CLIENT_ID'],
                        'EVENT_ID' => $arAttrs['EVENT_ID'],
                        'GIFT_RECIPIENT_ID' => $arAttrs['GIFT_RECIPIENT_ID'],
                        'EVENT_DATE' => date('Y-m-d', strtotime($arAttrs['RECEIVING_DATE_START']))
                    ]);
                    $obCLientEvent->save();
                }
                catch(\Exception $e){
                    Yii::trace($e->getMessage(), 'flower');
                }

            }
        }
    }


    /**
     * Setting correct model fields values
     */
    public function afterFind()
    {
        parent::afterFind();
        $arAttrs = $this->getAttributes();
        
        if( !empty($arAttrs['GIFT_RECIPIENT_ID']) ){
            $this->GIFT_RECIPIENT = $this->getGiftRecipient()->one()['NAME'];
        }

        if( !empty($arAttrs['EVENT_ID']) ){
            $this->EVENT = $this->getEvent()->one()['NAME'];
        }

        if( !empty($arAttrs['CLIENT_ID']) ){
            $this->CLIENT = $this->getClient()->one()['NAME'];
        }

        if( !empty($arAttrs['OPERATOR_ID']) ){
            $this->OPERATOR = $this->getOperator()->one()['username'];
        }

        if( !empty($arAttrs['SUM']) ){
            $this->SUM_FORMATTED = $arAttrs['SUM'] . ' <i class="fa fa-rub"></i>';
        }

        if( !empty($arAttrs['PREPAYMENT']) ){
            $this->PREPAYMENT_FORMATTED = $arAttrs['PREPAYMENT'] . ' <i class="fa fa-rub"></i>';
        }

        if( !empty($arAttrs['RECEIVING_DATE_START']) ){
            $this->RECEIVING_TIME_START = date('H:i', strtotime($arAttrs['RECEIVING_DATE_START']));
        }

        if( !empty($arAttrs['RECEIVING_DATE_END']) ){
            $this->RECEIVING_TIME_END = date('H:i', strtotime($arAttrs['RECEIVING_DATE_END']));
        }
    }


    /**
     * Getting bouquets list
     * 
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getBouquets()
    {
        $arBouquets = static::find()
            ->where(['TYPE' => ['B', 'P'], 'STATUS' => 'C'])
            ->select([
                'ID',
                'NAME',
                'IMAGE',
                'TYPE',
                'RETAIL_PRICE' => 'TOTAL',
            ])
            ->asArray()
            ->all();

        array_walk($arBouquets, function(&$arElem){
            $arElem['AMOUNT'] = 1;
			$arElem['CAN_SELL'] = $arElem['TYPE'] == 'P' ? false : true;
			$arElem['TYPE'] = 'BOUQUET';
            $arElem['catalogSection']['NAME'] = 'Букеты';
        });
        unset($arElement);
        
        return $arBouquets;
    }


    /**
     * Disbanding bouquet
     * 
     * @param $id - bouquet id
     *
     * @return bool
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function disbandBouquet($id)
    {
        $obOrder = $this->findOne($id);
        if( empty($obOrder->ID) ){
            throw new \Exception('Bouquet not found!');
        }
        
        $obConnection = Yii::$app->db;
        $obTransaction = $obConnection->beginTransaction();

        try{
            # Returning goods to the stock
            $arOrderGoods = OrdersGoods::getList(['filter' => ['ORDER_ID' => $id]]);
            if( !empty($arOrderGoods) ){
                $arGoods = CatalogProducts::getList([
                        'filter' => ['ID' => array_column($arOrderGoods, 'GOOD_ID')],
                ], 0);

                foreach($arOrderGoods as $arOrderGood){
                    $obGood = new CatalogProducts();
                    $obGood->isNewRecord = false;
                    $obGood->ID = $arOrderGood['GOOD_ID'];
                    $obGood->setOldAttributes($arGoods[$arOrderGood['GOOD_ID']]);
                    $obGood->setAttributes(
                        array_merge($arGoods[$arOrderGood['GOOD_ID']], ['AMOUNT' => $arGoods[$arOrderGood['GOOD_ID']]['AMOUNT'] + $arOrderGood['AMOUNT']])
                    );

                    $obGood->save(false);
                }
            }

            # Canceling order-bouquet
            $obOrder->setAttribute('STATUS', 'CNC');
            $obOrder->save();
        }
        catch(\Exception $e){
            Yii::trace($e->getMessage(), 'flower');
            $obTransaction->rollBack();
        }

        $obTransaction->commit();
        return true;
    }


    /**
     * @param $orderId
     *
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getOrderInfo($orderId)
    {
        return Orders::find()->andWhere(['ID' => $orderId])->asArray()->one();
    }
    


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['ID' => 'CLIENT_ID'])->inverseOf('orders');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Events::className(), ['ID' => 'EVENT_ID'])->inverseOf('orders');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGiftRecipient()
    {
        return $this->hasOne(GiftRecipients::className(), ['ID' => 'GIFT_RECIPIENT_ID'])->inverseOf('orders');
    }


    /**
     * @return $this
     */
    public function getOrdersOperators()
    {
        return $this->hasMany(OrdersOperators::className(), ['ORDER_ID' => 'ID'])->inverseOf('orders');
    }


    /**
     * @return $this
     */
    public function getOrdersGoods()
    {
        return $this->hasMany(OrdersGoods::className(), ['ORDER_ID' => 'ID'])->inverseOf('orders');
    }
}