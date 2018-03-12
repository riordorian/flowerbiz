<?php

namespace app\controllers;

use app\models\LoyaltyPrograms;
use Yii;
use app\models\ClientsGroups;
use app\models\ClientsGroupsSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientsGroupsController implements the CRUD actions for ClientsGroups model.
 */
class ClientsGroupsController extends AdminController
{
    public $viewPath = '/admin/clients-groups/';

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
     * Lists all ClientsGroups models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientsGroupsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 15;

        $this->listCount = $dataProvider->getCount();

        return $this->render($this->viewPath . 'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClientsGroups model.
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
     * Creates a new ClientsGroups model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ClientsGroups();
        $arLoyalties = LoyaltyPrograms::getFilterValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render($this->viewPath . 'create', [
                'model' => $model,
                'arLoyalties' => $arLoyalties
            ]);
        }
    }

    /**
     * Updates an existing ClientsGroups model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $arLoyalties = LoyaltyPrograms::getFilterValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render($this->viewPath . 'update', [
                'model' => $model,
                'arLoyalties' => $arLoyalties
            ]);
        }
    }

    /**
     * Deletes an existing ClientsGroups model.
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
     * Finds the ClientsGroups model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClientsGroups the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClientsGroups::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
