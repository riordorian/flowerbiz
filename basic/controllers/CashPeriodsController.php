<?php

namespace app\controllers;

use app\models\MoneyMovements;
use app\models\User;
use Yii;
use app\models\Cashperiods;
use app\models\CashperiodsSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CashPeriodsController implements the CRUD actions for Cashperiods model.
 */
class CashPeriodsController extends AdminController
{
    public $viewPath = '/admin/cash-periods/';

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
     * Lists all Cashperiods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CashperiodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort([
            'defaultOrder' => ['ID' => SORT_DESC]
        ]);
        $dataProvider->setPagination(['pageSize' => 10]);

        return $this->render($this->viewPath . 'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Cashperiods model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = 'empty';
        $model = $this->findModel($id);
        $model->CASH_INCOMES = $model->CARDS_INCOMES = 0;

        # Gettiong operations
        $arMoneyMovements = $arUsersIds = $arUsers = [];
        $arMMovements = $model->getCashPeriodOperations($model->CASHBOX_ID, $model->CLOSING_TIME, $model->OPENING_TIME);

        foreach($arMMovements as $k => $obMovement){
            # Automatic operation
            /*if( strtotime($obMovement->DATE) == strtotime($model->OPENING_TIME)  ){
                unset($arMMovements[$k]);
                continue;
            }*/

            $arUsersIds[] = $obMovement->USER_ID;
            if($obMovement->moneyAccount->TYPE == 'CASH'){
                $model->CASH_INCOMES = $model->CASH_INCOMES + ($obMovement->TYPE == 'INCOME' ? 1 : -1) * $obMovement->AMOUNT;
            }
            elseif( $obMovement->moneyAccount->TYPE == 'CARD' ){
                $model->CARDS_INCOMES = $model->CARDS_INCOMES + ($obMovement->TYPE == 'INCOME' ? 1 : -1) * $obMovement->AMOUNT;
            }
            
            $arMoneyMovements[$obMovement->ID] = [
                'NAME' => $obMovement->NAME,
                'AMOUNT' => $obMovement->AMOUNT,
                'USER' => $obMovement->USER_ID,
                'COMMENT' => $obMovement->COMMENT,
            ];
        }
        
        # Getting operations users info
        $arUsersInfo = User::find()->where(['id' => $arUsersIds])->all();
        foreach($arUsersInfo as $obUser){
            $arUsers[$obUser->ID] = $obUser->username;
        }

        foreach($arMMovements as $obMovement){
            $arUsersIds[] = $obMovement->USER_ID;
        }
        

        return $this->render($this->viewPath . 'view', [
            'model' => $model,
            'arMoneyMovements' => $arMMovements,
            'arUsers' => $arUsers
        ]);
    }

    /**
     * Creates a new Cashperiods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionOpen()
    {
        $this->layout = 'empty';
        $model = new Cashperiods();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->refresh();
            return $this->redirect(['index']);
        } else {
            return $this->render($this->viewPath . 'open', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Close cash period
     * @return mixed
     */
    public function actionClose($id)
    {

        if( empty($id) ){
            throw new \Exception('Inctorrect params');
        }
        try{
            $obModel = $this->findModel($id);
            if( empty($obModel) ){
                throw new \Exception('Model not found');
            }            
            $obModel->CLOSING_TIME = date('Y-m-d H:i:s');
            
            if( $obModel->save() ){
                echo json_encode(['STATUS' => true, 'CALLBACK' => 'closeCashperiod']);
            }
        }
        catch(\Exception $e){
            Yii::trace('Closing cash period error', 'flower');
        }
    }

    /**
     * Updates an existing Cashperiods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render($this->viewPath . 'update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Cashperiods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cashperiods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cashperiods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cashperiods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
