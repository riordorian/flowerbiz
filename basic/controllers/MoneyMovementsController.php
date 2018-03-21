<?php

namespace app\controllers;

use app\models\MoneyAccounts;
use Yii;
use app\models\MoneyMovements;
use app\models\MoneyMovementsSearch;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MoneyMovementsController implements the CRUD actions for MoneyMovements model.
 */
class MoneyMovementsController extends AdminController
{
    public $viewPath = '/admin/money-movements/';

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
     * Lists all MoneyMovements models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MoneyMovementsSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort([
                'defaultOrder' => ['ID' => SORT_DESC]
            ]
        );
        
        return $this->render($this->viewPath . 'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MoneyMovements model.
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
     * Creates a new MoneyMovements model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'empty';

        $model = new MoneyMovements();
        $arPost = Yii::$app->request->post();
        $model->TYPE = empty($arPost['TYPE']) ? reset($model->arOpTypes) : $arPost['TYPE'];

        if ($model->load(Yii::$app->request->post()) && $model->save() ) {
            return $this->render($this->viewPath . '_success', []);
        } else {
            $model->TYPE = empty($arPost['MoneyMovements']['TYPE']) ? 'INCOME' : $arPost['MoneyMovements']['TYPE'];

            return $this->render($this->viewPath . 'create', [
                'model' => $model,
                'arTypes' => $model->arOpTypes,
            ]);

        }
    }

    /**
     * Updates an existing MoneyMovements model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = 'empty';

        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->ID]);
        } else {
            return $this->render($this->viewPath . 'update', [
                'model' => $model,
                'arTypes' => $model->arOpTypes
            ]);
        }
    }

    /**
     * Deletes an existing MoneyMovements model.
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
     * Finds the MoneyMovements model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MoneyMovements the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MoneyMovements::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
