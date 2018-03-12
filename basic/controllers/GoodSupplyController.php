<?php

namespace app\controllers;

use app\models\CatalogProducts;
use app\models\GoodsSupplies;
use app\models\Providers;
use Yii;
use app\models\GoodSupply;
use app\models\GoodSupplySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoodSupplyController implements the CRUD actions for GoodSupply model.
 */
class GoodSupplyController extends Controller
{
    /**
     * @var string
     */
    protected $viewPath = '/admin/good-supply/';

    /**
     * Controller layout
     * @var string
     */
    public $layout = 'admin.php';

    /**
     * Main body class
     * @var string
     */
    public $bodyClass = 'animated_fill-none';

    /**
     * List items count
     * @var string
     */
    public $listCount = '';

    /**
     * Main body class
     * @var string
     */
    public $fixHeading = false;

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
     * Lists all GoodSupply models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodSupplySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render($this->viewPath . 'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GoodSupply model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render($this->viewPath . 'view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new GoodSupply model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GoodSupply();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->ID]);
        } else {
            return $this->render($this->viewPath . 'create', [
                'model' => $model,
                'arProviders' => Providers::getFilterValues()
            ]);
        }
    }

    /**
     * Updates an existing GoodSupply model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelGoodsSupplies = new GoodsSupplies();
        $arSupplyGoods = $modelGoodsSupplies
            ->find()
            ->where(['GOOD_SUPPLY_ID' => $id])
            ->select(['ID', 'GOOD_SUPPLY_ID', 'GOOD_ID', 'AMOUNT', 'PRICE'])
            ->all();
        
        

        if ($model->load(Yii::$app->request->post()) ) {
            $model->save();
            return $this->redirect(['view', 'id' => $model->ID]);
        }
        elseif( $modelGoodsSupplies->load(Yii::$app->request->post() )){
            $arNewProps = $modelGoodsSupplies->getAttributes();

            $modelGoodsSupplies->addGood($arNewProps['GOOD_SUPPLY_ID'], $arNewProps['GOOD_ID'], $arNewProps['AMOUNT']);
            
        }

        else {
            return $this->render($this->viewPath . 'update', [
                'arProviders' => Providers::getFilterValues(),
                'model' => $model,
                'modelGoodsSupplies' => $modelGoodsSupplies,
                'arGoods' => CatalogProducts::getFilterValues(),
                'arSupplyGoods' => $arSupplyGoods
            ]);
        }
    }

    /**
     * Deletes an existing GoodSupply model.
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
     * Finds the GoodSupply model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GoodSupply the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodSupply::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
