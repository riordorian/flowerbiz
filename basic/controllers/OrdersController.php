<?php

namespace app\controllers;

use app\models\Cashboxes;
use app\models\Cashperiods;
use app\models\CatalogProducts;
use app\models\CatalogSections;
use app\models\Clients;
use app\models\Events;
use app\models\GiftRecipients;
use app\models\MoneyAccounts;
use app\models\MoneyMovements;
use app\models\Operators;
use app\models\OrdersGoods;
use app\models\OrdersOperators;
use Faker\Provider\DateTime;
use Yii;
use app\models\Orders;
use app\models\OrdersSearch;
use yii\data\ActiveDataProvider;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends PrototypeController
{
    public $viewPath = '/terminal/orders/';

    public $layout = 'terminal';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $arReq = Yii::$app->getRequest()->queryParams;
        
        if( Yii::$app->user->can('terminalWork') === false ){
            Yii::$app->user->logout();
            $this->redirect('/terminal/login/');
        }

        $arCategories = CatalogSections::find()->orderBy(['SORT' => SORT_DESC])->asArray()->all();
        foreach($arCategories as &$arCategory){
            if( empty($arCategory['IMAGE']) || !file_exists(Yii::getAlias('@webroot') . $arCategory['IMAGE']) ){
                $arCategory['IMAGE'] = '/uploads/dummy.jpg';
            }
        }
        unset($arCategory);
        array_unshift($arCategories, ['ID' => 0, 'NAME' => 'Букеты', 'IMAGE' => '/uploads/bouquets.jpg']);
        $arOperator = Operators::find()->where(['id' => Yii::$app->user->id])->asArray()->one();

        # Working with cash-periods
        $obPeriods = new Cashperiods();
        Yii::$app->params['OPENED_PERIODS'] = $arOpenedCashPeriods = $obPeriods->getOpenedPeriods();
        $bNeedClosePeriod = false;
        $lastOpenedPeriod = 0;
        if( !empty($arOpenedCashPeriods) ){
            $lastOpenedPeriod = reset($arOpenedCashPeriods)['ID'];
            
            foreach($arOpenedCashPeriods as $arPeriod){
                if( strtotime(date('d-m-Y')) > strtotime(date('d.m.Y', strtotime($arPeriod['OPENING_TIME']))) ){
                    $bNeedClosePeriod = true;
                }
            }
        }

        $arOrderInfo = [];
        if( !empty($arReq['ORDER_ID']) ){
            $arOrderInfo = Orders::getOrderInfo($arReq['ORDER_ID']);
        }

        return $this->render($this->viewPath . 'index', [
            'arCategories' => $arCategories,
            'arOperator' => $arOperator,
            'arOpenedCashPeriods' => $arOpenedCashPeriods,
            'bNeedClosePeriod' => $bNeedClosePeriod,
            'lastOpenedPeriod' => $lastOpenedPeriod,
            'arOrderInfo' => $arOrderInfo
        ]);
    }


    /**
     * Getting products list
     * 
     * @param int    $categoryId
     * @param string $name
     *
     * @return string
     */
    public function actionGoodsList($categoryId = 0, $name = '')
    {
        
        $this->layout = 'empty';
        $arGoods = [];
        $rsGoods = CatalogProducts::find();
        $rsGoods->andWhere(['>', 'AMOUNT', 0]);
        
        if( !empty($categoryId) || !empty($name) ){
            if( !empty($categoryId) ){
                $rsGoods->andWhere(['CATALOG_SECTION_ID' => $categoryId]);
            }
            elseif( !empty($name) ){
                $rsGoods->andWhere(['like', 'NAME', $name]);
            }

            $arGoods = $rsGoods->select(['ID', 'NAME', 'AMOUNT', 'IMAGE', 'RETAIL_PRICE', 'CATALOG_SECTION_ID'])->with('catalogSection')->asArray()->all();
        }
        elseif( $categoryId == 0 && empty($name) ){
            $arGoods = Orders::getBouquets();
        }
        
        foreach($arGoods as &$arGood){
            if( empty($arGood['IMAGE']) || !file_exists(Yii::getAlias('@webroot') . $arGood['IMAGE']) ){
                $arGood['IMAGE'] = '/uploads/dummy.jpg';
            }
            if( empty($arGood['TYPE']) ){
                $arGood['TYPE'] = 'FLOWER';
            }
        }
        unset($arGood);
        
        return $this->render($this->viewPath . 'goods-list', [
            'arGoods' => $arGoods
        ]);
    }


    /**
     * Getting products sections list
     * 
     * @return string
     */
    public function actionSectionsList()
    {
        $this->layout = 'empty';
        $arSections = CatalogSections::find()->orderBy(['SORT' => SORT_DESC])->asArray()->all();
        foreach($arSections as &$arSection){
            if( empty($arSection['IMAGE']) || !file_exists(Yii::getAlias('@webroot') . $arSection['IMAGE']) ){
                $arSection['IMAGE'] = '/uploads/dummy.jpg';
            }
        }
        unset($arSection);
        array_unshift($arSections, ['ID' => 0, 'NAME' => 'Букеты', 'IMAGE' => '/uploads/bouquets.jpg']);

        return $this->render($this->viewPath . 'sections-list', [
            'arSections' => $arSections
        ]);
    }


    /**
     * Updating good info
     * 
     * @param $goodId
     */
    public function actionUpdateInfo($goodId)
    {
        $this->layout = 'empty';
        if( empty($goodId) ){
            echo json_encode(['STATUS' => false, 'ERROR_MESSAGE' => 'Incorrect params']);
        }
        
        $arGood = CatalogProducts::find()->where(['ID' => $goodId])->asArray()->one();

        echo json_encode($arGood);
    }



    /**
     * Getting client discounts
     *
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function actionGetUserDiscounts()
    {
        $arReq = \Yii::$app->getRequest()->getBodyParams();

        if( !empty($arReq['USER_ID']) ){
            $arDiscounts = Clients::getClientDiscounts($arReq['USER_ID']);
        }

        return json_encode($arDiscounts);

    }


    /**
     * Open sale popup
     * 
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSale()
    {
        $arReq = \Yii::$app->request->getBodyParams();
        $this->layout = 'empty';

        return $this->render('/terminal/sale.php', [
            'arMoneyAccounts' => MoneyAccounts::getFilterValues(['USE_ON_CASHBOX' => 1]),
            'arOperators' => !empty($arReq['OPERATORS']) ? $arReq['OPERATORS'] : [],
            'arGoods' => empty($arReq['CatalogProducts']) ? [] : $arReq['CatalogProducts'],
            'total' => empty($arReq['TOTAL']) ? 0 : $arReq['TOTAL'],
            'discount' => empty($arReq['DISCOUNT']) ? 0 : $arReq['DISCOUNT'],
            'bonus' => empty($arReq['BONUS']) ? 0 : $arReq['BONUS'],
            'prepayment' => empty($arReq['PREPAYMENT']) ? 0 : $arReq['PREPAYMENT'],
            'clientId' => empty($arReq['CLIENT_ID']) ? 0 : $arReq['CLIENT_ID'],
            'orderId' => empty($arReq['ORDER_ID']) ? '' : $arReq['ORDER_ID'],
            'sum' => empty($arReq['SUM']) ? 0 : $arReq['SUM'],
            
            'obMoneyAccounts' => new MoneyAccounts(),
            'obOrders' => new Orders(),
            'obOrdersGoods' => new OrdersGoods(),
            'obOrdersOperators' => new OrdersOperators(),
            'obClients' => new Clients(),
        ]);
    }


    /**
     * Making bouquet
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionBouquet()
    {
        $arReq = \Yii::$app->request->getBodyParams();
        $this->layout = 'empty';
        $obOrders = new Orders();
        $orderId = empty($arReq['ORDER_ID']) ? '' : $arReq['ORDER_ID'];
        $arOrder = [];
        $step = '';
        
        if( !empty($orderId) ){
            $arOrder = $obOrders->find()->where(['ID' => $orderId])->asArray()->one();
            $step = 'C';
        }

        return $this->render('/terminal/bouquet.php', [
            'arOperators' => !empty($arReq['OPERATORS']) ? $arReq['OPERATORS'] : [],
            'arGoods' => empty($arReq['CatalogProducts']) ? [] : $arReq['CatalogProducts'],
            'total' => empty($arReq['TOTAL']) ? 0 : $arReq['TOTAL'],
            'discount' => empty($arReq['SUM']) ? 0 : $arReq['SUM'] - $arReq['TOTAL'],
            'orderId' => $orderId,
            'sum' => empty($arReq['SUM']) ? 0 : $arReq['SUM'],
            'arReq' => $arReq,
            'arOrder' => $arOrder,
            'step' => $step,
            
            'obOrders' => $obOrders,
            'obOrdersGoods' => new OrdersGoods(),
            'obOrdersOperators' => new OrdersOperators(),
        ]);
    }


    /**
     * Disbanding bouquet
     * 
     * @param $id - bouquet id
     */
    public function actionDisbandBouquet($id)
    {
        $arResult = ['STATUS' => false];

        try{
            $obModel = new Orders();
            $bDeleted = $obModel->disbandBouquet($id);

            $arResult = [
                'STATUS' => true,
                'CALLBACK' => 'deleteBouquet'
            ];
        }
        catch(\Exception $e){
            Yii::trace($e->getMessage(), 'flower');
        }

        return json_encode($arResult);
    }


    /**
     * List of order goods
     * @param $id
     *
     * @return string
     */
    public function actionGetOrderGoods($id)
    {
        $this->layout = 'empty';
        $dataProvider = new ActiveDataProvider([
            'query' => OrdersGoods::find()->where(['ORDER_ID' => $id])->with('good'),
        ]);

        return $this->render('/terminal/orders/order_goods.php', [
            'dataProvider' => $dataProvider 
        ]);
    }


    /**
     * Saving order
     * 
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionSave()
    {
        $this->layout = 'empty';
        $arReq = \Yii::$app->request->post();
        $obConnection = Yii::$app->db;
        $obTransaction = $obConnection->getTransaction();
        if( empty($this->obTransaction) ){
            $obTransaction = $obConnection->beginTransaction();
        }

        try{
            $obOrders = new Orders();
            if( $obOrders->load($arReq) ){
                $step = $obOrders->STEP;
                $total = $obOrders->TOTAL;
                $discount = $obOrders->DISCOUNT;

                # Saving order
                if( !empty($arReq['Orders']['ID']) ){
                    $obOrders = $this->findModel($arReq['Orders']['ID']);
                    

                    if( !empty($obOrders) ){
                        $obOrders->ID = $arReq['Orders']['ID'];
                    }
                }
                else{
                    $obOrders->setAttributes([
                        'NAME' => empty($arReq['NAME']) ? 'Заказ ' . date('d.m.Y H:i:s') : $arReq['NAME'],
                    ]);
                }

                # Set attributes for pre orders
                if( !empty($obOrders->ID) && $obOrders->TYPE == 'P' && $step == 'C' ){
                    $obOrders->setAttributes(
                        [
                            'STATUS' => 'C',
                            'TOTAL' => $total,
                            'SUM' => $discount,
                        ]
                    );
                }
                else{
                    $obOrders->setAttributes(
                        [
                            'PAYMENT_STATUS' => !empty($arReq['CLOSE_WITHOUT_PAYMENT']) ? 'W' : 'F',
                            'STATUS' => 'F',
                            'SELLING_TIME' => date('Y-m-d H:i:s')
                        ]
                    );
                }

                # Set attributes for bouquets
                if( empty($obOrders->ID) ){
                    # Statuses for bouquets
                    if( $obOrders->TYPE == 'B' ){
                        $obOrders->setAttributes([
                            'PAYMENT_STATUS' => 'N',
                            'STATUS' => 'C',
                            'SELLING_TIME' => ''
                        ]);
                        
                    }

                    if( empty($obOrders->TYPE) ){
                        $obOrders->setAttributes([
                            'TYPE' => 'S'
                        ]);
                    }
                }

                $bOrderSaved = $this->saveModel($obOrders);
                if( !$bOrderSaved ){
                    $obTransaction->rollBack();
                    return false;
                }


                # Saving operators
                $bOperatorsSaved = true;
                $obOrdersOperators = new OrdersOperators();
                if( $obOrdersOperators->load($arReq) ){
                    $arOperators = $obOrdersOperators->getAttribute('OPERATOR_ID');
                    foreach($arOperators as $operatorId){
                        $obOrdersOperators->isNewRecord = true;
                        $obOrdersOperators->ID = NULL;
                        $obOrdersOperators->setAttributes([
                            'ORDER_ID' => $obOrders->ID,
                            'OPERATOR_ID' => $operatorId,
                        ]);

                        # TODO: Не работает валидация
                        if( !$obOrdersOperators->save(false) ){
                            $bOperatorsSaved = false;
                            $obTransaction->rollBack();
                            return;
                        }
                    }
                }
                elseif( empty($obOrders->ID) ){
                    $obTransaction->rollBack();
                    return;
                }

                # Saving order goods
                $bGoodsSaved = true;
                $obOrdersGoods = new OrdersGoods();
                $obGoods = new CatalogProducts();
                $arObGoods = [];
                if( $obOrdersGoods->load($arReq) ){
                    $arGoods = $obOrdersGoods->getAttribute('GOOD_ID');
                    $arTmpObGoods = $obGoods->findAll(['ID' => array_keys($arGoods)]);
                    foreach($arTmpObGoods as $obGood){
                        $arObGoods[$obGood->ID] = $obGood;
                    }
                    
                    foreach($arGoods as $goodId => $goodAmount){
                        $obOrdersGoods->isNewRecord = true;
                        $obOrdersGoods->ID = NULL;
                        $obOrdersGoods->setAttributes([
                            'ORDER_ID' => $obOrders->ID,
                            'GOOD_ID' => $goodId,
                            'AMOUNT' => $goodAmount,
                        ]);
                        
                        $arObGoods[$goodId]->updateCounters(['AMOUNT' => $goodAmount * (-1)]);

                        # TODO: Не работает валидация
                        if( !$obOrdersGoods->save(false) ){
                            $bGoodsSaved = false;
                            $obTransaction->rollBack();
                            return;
                        }
                    }
                }
                elseif( empty($obOrders->ID) ){
                    $obTransaction->rollBack();
                    return;
                }

                
                $bTransactionDone = true;
                $obMoneyMovements = new MoneyMovements();
                $obMoneyAccounts = new MoneyAccounts();
                if( $obMoneyAccounts->load($arReq) && $obOrders['TYPE'] != 'B' ){
                    $arTransactions = $obMoneyAccounts->getAttribute('BALANCE');
                    foreach($arTransactions as $accId => $sum){
                        if( $sum == 0 ){
                            continue;
                        }
                        
                        $obMoneyMovements->isNewRecord = true;
                        $obMoneyMovements->ID = NULL;
                        $obMoneyMovements->setAttributes([
                            'TYPE' => 'INCOME',
                            'AMOUNT' => $sum,
                            'MONEY_ACCOUNT' => $accId,
                            'ORDER_ID' => $obOrders->ID,
                            'USER_ID' => Yii::$app->user->id,
                            'CASHBOX_ID' => 1,
                            'DATE' => date('Y-m-d H:i:s'),
                            'NAME' => 'Операция по заказу ' . $obOrders->ID,
                        ]);
                        
                        if( !$obMoneyMovements->save(false) ){
                            $bTransactionDone = false;
                            $obTransaction->rollBack();
                            return;
                        }
                    }

                    # Add change operation
                    if( array_sum($arTransactions) > $total ){
                        $obMoneyMovements->isNewRecord = true;
                        $obMoneyMovements->ID = NULL;
                        $obMoneyMovements->setAttributes([
                            'TYPE' => 'CONSUMPTION',
                            'AMOUNT' => array_sum($arTransactions) - $total,
                            # TODO: Доделать получение ID Наличного счета
                            'MONEY_ACCOUNT' => 1,
                            'ORDER_ID' => $obOrders->ID,
                            'USER_ID' => Yii::$app->user->id,
                            'CASHBOX_ID' => 1,
                            'DATE' => date('Y-m-d H:i:s'),
                            'NAME' => 'Операция по заказу ' . $obOrders->ID,
                        ]);


                        if( !$obMoneyMovements->save(false) ){
                            $bTransactionDone = false;
                            $obTransaction->rollBack();
                            return;
                        }
                    }
                }
                elseif( $obOrders['TYPE'] != 'B' && ($obOrders['TYPE'] == 'P' && $step == 'C') === false ){
                    $obTransaction->rollBack();
                    return;
                }
                

                # Saving all info only if all operations done
                if( $bOrderSaved && $bOperatorsSaved && $bGoodsSaved && $bTransactionDone ){
                    $obTransaction->commit();
                    return $this->render('/terminal/orders/_success' . (($obOrders->TYPE == 'B') ? '_bouquet' : '' . '.php'));
                }
                else{
                    $obTransaction->rollBack();
                }
            }
        }
        catch(\Exception $e){
            $obTransaction->rollBack();
            return $this->render('/terminal/orders/_error.php', ['message' => $e->getMessage()]);
        }


    }



    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/terminal/']);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
