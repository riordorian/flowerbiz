<?php

namespace app\controllers;

use app\models\CatalogProducts;
use app\models\MoneyMovements;
use Yii;
use app\models\MoneyAccounts;
use app\models\MoneyAccountsSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MoneyAccountsController implements the CRUD actions for MoneyAccounts model.
 */
class MoneyAccountsController extends AdminController
{
    public $viewPath = '/admin/money-accounts/';

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
     * Lists all MoneyAccounts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MoneyAccountsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize = 15;
        $this->listCount = $dataProvider->getCount();

        return $this->render($this->viewPath . 'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MoneyAccounts model.
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
     * Creates a new MoneyAccounts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MoneyAccounts();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render($this->viewPath . 'create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MoneyAccounts model.
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
     * Deletes an existing MoneyAccounts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $arProducts = MoneyMovements::getList(['filter' => ['MONEY_ACCOUNT' => $id], 'limit' => 1], 0);
        if( !empty($arProducts) ){
            return $this->redirect('/admin/money-accounts/?DELETE_ERROR=Y');
        }
        else{
            $this->findModel($id)->delete();
        }


        return $this->redirect(['index']);
    }

    /**
     * Finds the MoneyAccounts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MoneyAccounts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MoneyAccounts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
