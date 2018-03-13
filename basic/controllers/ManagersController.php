<?php

namespace app\controllers;

use app\models\Managers;
use app\models\User;
use Yii;
use app\models\Clients;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientsController implements the CRUD actions for Clients model.
 */
class ManagersController extends AdminController
{
    public $viewPath = '/admin/managers/';

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
     * Lists all operators models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Managers::getList([
                'RETURN_TYPE' => 'QUERY'
            ]),
        ]);
        

        return $this->render($this->viewPath . 'index', [
            'dataProvider' => $dataProvider,
//            'arOperators' => []
        ]);
    }

    /**
     * Displays a single Clients model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Managers();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render($this->viewPath . 'create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $obModel = new Managers();
        $model = $obModel->findElem($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render($this->viewPath . 'update', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Deletes an existing Managers model.
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
     * Finds the Clients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
