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
 * GoodSuppliesController implements the CRUD actions for GoodSupply model.
 */
class GoodSuppliesController extends AdminController
{
    /**
     * @var string
     */
    protected $viewPath = '/admin/good-supply/';


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Deletes an existing GoodSupply model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	$obModel = $this->findModel($id);
    	$arAttrs = $obModel->getAttributes();
        $obModel->delete();

        return $this->redirect(['/admin/good-supply/update/?id=' . $arAttrs['GOOD_SUPPLY_ID']]);
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
        if (($model = GoodsSupplies::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
