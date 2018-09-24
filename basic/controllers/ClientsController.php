<?php

namespace app\controllers;

use app\models\ClientsClientsGroups;
use app\models\ClientsClientsTypes;
use app\models\ClientsEvents;
use app\models\ClientsGiftRecipients;
use app\models\ClientsGroups;
use app\models\Events;
use app\models\GiftRecipients;
use Yii;
use app\models\Clients;
use app\models\ClientsTypes;
use app\models\ClientsSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientsController implements the CRUD actions for Clients model.
 */
class ClientsController extends AdminController
{
    public $viewPath = '/admin/clients/';

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
     * Lists all Clients models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->pagination->pageSize = 15;
//        $this->listCount = $dataProvider->getCount();
        $this->listCount = $dataProvider->getTotalCount();

        return $this->render($this->viewPath . 'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
     * Creates a new Clients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Clients();
        $modelCTypes = new ClientsTypes();
        $modelCCTypes = new ClientsClientsTypes();
        $modelCCGroups = new ClientsClientsGroups();
        $arPost = Yii::$app->request->post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            # Getting of the clients types array
            $arCTypes = ClientsTypes::getFilterValues();

            # Getting of the clients groups array
            $arCGroups = ClientsGroups::getFilterValues();

            # Getting the default client type
            $defaultCType = current(array_keys($arCTypes));

            # Checking that the main client type is selected
            $bDefCTypeChecked = ( empty($arPost['ClientsClientsTypes']['CLIENT_TYPE_ID'])
                || $arPost['ClientsClientsTypes']['CLIENT_TYPE_ID'] == $defaultCType );

            $modelCCTypes->CLIENT_TYPE_ID = $bDefCTypeChecked ? $defaultCType : $arPost['ClientsClientsTypes']['CLIENT_TYPE_ID'];

            return $this->render($this->viewPath . 'create', [
                'model' => $model,
                'modelCTypes' => $modelCTypes,
                'modelCCTypes' => $modelCCTypes,
                'modelCCGroups' => $modelCCGroups,
                'arCTypes' => $arCTypes,
                'arCGroups' => $arCGroups,
                'bDefCTypeChecked' => $bDefCTypeChecked,
                'nameLabel' => $bDefCTypeChecked ? $model->getAttributeLabel('NAME') : 'Название'
            ]);
        }
    }

    /**
     * Updates an existing Clients model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $obModel = new Clients();
        $model = $obModel->findElem($id, [
            'with' => [
                'clientsClientsTypes',
                'clientsClientsGroups',
                'clientsEvents',
            ]
        ]);
        $arRelated = $model->getRelatedRecords();
        $modelCTypes = new ClientsTypes();
        $modelCCTypes = $arRelated['clientsClientsTypes'];

        $modelCCGroups = empty($arRelated['clientsClientsGroups']) ? new ClientsClientsGroups() : $arRelated['clientsClientsGroups'];

        $modelCEvents = new ClientsEvents();
        $arModelCEvents = $arRelated['clientsEvents'];


        # Getting of the clients types array
        $arCTypes = ClientsTypes::getFilterValues();

        # Getting of the clients groups array
        $arCGroups = ClientsGroups::getFilterValues();

        # Getting of the events types array
        $arEvents = Events::getFilterValues();

        # Getting of the gift recipients array
        $arRecipients = GiftRecipients::getFilterValues();
        
        # Getting the default client type
        $defaultCType = current(array_keys($arCTypes));

        # Checking that the main client type is selected
        $bDefCTypeChecked = $modelCCTypes->CLIENT_TYPE_ID == $defaultCType;

        if( $model->load(Yii::$app->request->post()) ) {
            $model->save();

//            return $this->redirect(['view', 'id' => $model->ID]);
        }
        else{
            # Adding or updating user events
            if( $modelCEvents->load(Yii::$app->request->post()) ){
                $arNewProps = $modelCEvents->getAttributes();

                $modelCExEvents = $modelCEvents->find()->where([
                    'GIFT_RECIPIENT_ID' => $arNewProps['GIFT_RECIPIENT_ID'],
                    'EVENT_ID' => $arNewProps['EVENT_ID'],
                    'CLIENT_ID' => $arNewProps['CLIENT_ID'],
                ])->one();
                

                if( !empty($modelCExEvents->ID) ){
                    $modelCExEvents->EVENT_DATE_DAY = $modelCEvents->EVENT_DATE_DAY;
                    $modelCExEvents->EVENT_DATE_MONTH = $modelCEvents->EVENT_DATE_MONTH;
                    $modelCEvents = $modelCExEvents;
                }

                $modelCEvents->save(true);
            }
        }

        $arCTypes = ClientsTypes::getFilterValues();

        return $this->render($this->viewPath . 'update', [
            'model' => $model,
            'modelCTypes' => $modelCTypes,
            'modelCCTypes' => $modelCCTypes,
            'modelCCGroups' => $modelCCGroups,
            'modelCEvents' => $modelCEvents,
            'arModelCEvents' => $arModelCEvents,
            'arCTypes' => $arCTypes,
            'arCGroups' => $arCGroups,
            'arEvents' => $arEvents,
            'arRecipients' => $arRecipients,
            'bDefCTypeChecked' => $bDefCTypeChecked,
            'nameLabel' => $bDefCTypeChecked ? $model->getAttributeLabel('NAME') : 'Название'
        ]);
    }

    /**
     * Deletes an existing Clients model.
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
        if (($model = Clients::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
