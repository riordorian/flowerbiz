<?php

namespace app\controllers;

use app\models\CatalogProducts;
use Yii;
use app\models\CatalogSections;
use app\models\CatalogSectionsSearch;
use yii\imagine\Image;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


/**
 * CatalogSectionsController implements the CRUD actions for CatalogSections model.
 */
class CatalogSectionsController extends AdminController
{
    public $viewPath = '/admin/catalog-sections/';

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
     * Lists all CatalogSections models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatalogSectionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize = 15;
        $this->listCount = $dataProvider->getCount();

        return $this->render($this->viewPath . 'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CatalogSections model.
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
     * Creates a new CatalogSections model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CatalogSections();
        if( $model->load(Yii::$app->request->post()) ) {
            $this->saveModel($model);

           return $this->redirect(['view', 'id' => $model->ID]);
        }
        else {
            return $this->render($this->viewPath . 'create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CatalogSections model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) ) {
            $this->saveModel($model);
            return $this->redirect(['view', 'id' => $model->ID]);
        }
        else {
            $model->IMAGE = $model->getOldAttribute('IMAGE');
            return $this->render($this->viewPath . 'update', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Deletes an existing CatalogSections model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $arProducts = CatalogProducts::getList(['filter' => ['CATALOG_SECTION_ID' => $id], 'limit' => 1], 0);
        if( !empty($arProducts) ){
            return $this->redirect('/admin/catalog-sections/?DELETE_ERROR=Y');
        }
        else{
            $this->findModel($id)->delete();
        }


        return $this->redirect(['index']);
    }

    /**
     * Finds the CatalogSections model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CatalogSections the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CatalogSections::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
