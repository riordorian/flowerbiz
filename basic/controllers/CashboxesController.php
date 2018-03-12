<?php

namespace app\controllers;

use Yii;
use app\models\Cashboxes;
use app\models\CashboxesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CashboxesController implements the CRUD actions for Cashboxes model.
 */
class CashboxesController extends AdminController
{
    public $viewPath = '/admin/cashboxes/';

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
     * Lists all Cashboxes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CashboxesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render($this->viewPath . 'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cashboxes model.
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
     * Creates a new Cashboxes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'empty';
        $model = new Cashboxes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render($this->viewPath . 'create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Cashboxes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = 'empty';
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
     * Deletes an existing Cashboxes model.
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
     * Finds the Cashboxes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cashboxes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cashboxes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
