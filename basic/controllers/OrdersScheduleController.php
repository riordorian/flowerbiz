<?php

namespace app\controllers;

use app\models\Events;
use app\models\GiftRecipients;
use app\models\OrdersOperators;
use Faker\Provider\DateTime;
use Yii;
use app\models\Orders;
use app\models\OrdersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdersScheduleController implements the CRUD actions for Orders model.
 */
class OrdersScheduleController extends Controller
{
    public $viewPath = '/terminal/orders-schedule/';

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
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = 'empty.php';
        $model = $this->findModel($id);
        
        return $this->render($this->viewPath . 'view', [
            'model' => $model,
            'obOrders' => new Orders(),

        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'empty.php';
        $arReq = Yii::$app->request->getQueryParams();
        $model = new Orders();
        $bHasChanges = $model->load(Yii::$app->request->post());

        # Setting payment status
        if( !empty($model->PREPAYMENT) ) {
            $model->setAttribute('PAYMENT_STATUS', 'P');
        }
        else{
            $model->setAttribute('PAYMENT_STATUS', 'N');
        }
        
        if ($bHasChanges && $model->save()) {
            return $this->render($this->viewPath . 'view', [
                'model' => $this->findModel($model->ID)
            ]);
        } else {
            # Getting of the gift recipients array
            $arRecipients = GiftRecipients::getFilterValues();

            # Getting of the gift recipients array
            $arEvents = Events::getFilterValues();

            return $this->render($this->viewPath . 'create', [
                'model' => $model,
                'date' => empty($arReq['DATE']) ? '' : date('d.m.Y', $arReq['DATE']),

                'arRecipients' => $arRecipients,
                'arEvents' => $arEvents
            ]);
        }
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = 'empty.php';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render($this->viewPath . 'view', [
                'model' => $this->findModel($model->ID)
            ]);
        } else {
            # Getting of the gift recipients array
            $arRecipients = GiftRecipients::getFilterValues();

            # Getting of the gift recipients array
            $arEvents = Events::getFilterValues();

            return $this->render($this->viewPath . 'update', [
                'model' => $model,
                'arRecipients' => $arRecipients,
                'arEvents' => $arEvents
            ]);
        }
    }


    /**
     * Updating order date by dropping
     */
    public function actionChangeDate()
    {
        if( Yii::$app->user->can('terminalWork') === false ){
            Yii::$app->user->logout();
            $this->redirect('/terminal/login/');
        }

        $arReq = \Yii::$app->getRequest()->get();
        if( !empty($arReq['ID']) && !empty($arReq['START']) ){
            $obOrder = Orders::find()->where(['ID' => $arReq['ID']])->one();

            $timeDiff = strtotime($obOrder->RECEIVING_DATE_END) - strtotime($obOrder->RECEIVING_DATE_START);
            $newEndDateTime = date('Y-m-d H:i:s', strtotime($arReq['START']) + $timeDiff);

            try{
                $obOrder->setAttributes([
                    'ID' => $arReq['ID'],
                    'RECEIVING_DATE_START' => $arReq['START'],
                    'RECEIVING_DATE_END' => $newEndDateTime
                ]);
                
                $obOrder->save();
                
                echo json_encode(['STATUS' => true]);
                die();
            }
            catch(\Exception $e){
                Yii::trace($e->getMessage(), 'flower');
                echo json_encode(['STATUS' => false, 'ERROR_MESSAGE' => 'Updating order error']);
                die();
            }

        }
        else{
            echo json_encode(['STATUS' => false, 'ERROR_MESSAGE' => 'Incorrect params']);
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

        return $this->redirect(['/terminal/calendar/']);
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
        if (($model = Orders::find()->andWhere(['ID' => $id])->with('ordersOperators')->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
