<?php

namespace app\controllers;

use app\models\Operators;
use budyaga\users\models\User;
use Yii;
use app\models\Clients;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientsController implements the CRUD actions for Clients model.
 */
class OperatorsController extends AdminController
{
    public $viewPath = '/admin/operators/';
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
            'query' => Operators::getList([
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
        $model = new Operators();
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
        $obModel = new Operators();
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
