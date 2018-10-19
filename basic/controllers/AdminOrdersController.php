<?php

namespace app\controllers;

use app\models\CatalogProducts;
use app\models\GoodsSupplies;
use app\models\Orders;
use app\models\OrdersSearch;
use app\models\Providers;
use Yii;
use app\models\GoodSupply;
use app\models\GoodSupplySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoodWritesOffController implements the CRUD actions for GoodSupply model.
 */
class AdminOrdersController extends AdminController
{
    /**
     * @var string
     */
    public $viewPath = '/admin/orders/';
    

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
     * Lists all GoodSupply models with type write-off.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $arParams = Yii::$app->request->queryParams;
        $arParams['OrdersSearch']['STATUS'] = 'F';
        $dataProvider = $searchModel->search($arParams);
        $dataProvider->pagination->pageSize = 10;
        $this->listCount = $dataProvider->getCount();

        return $this->render($this->viewPath . 'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
