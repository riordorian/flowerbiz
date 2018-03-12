<?php

namespace app\controllers;

use app\models\ClientsGroups;
use app\models\LoyaltyProgramsSteps;
use Yii;
use app\models\LoyaltyPrograms;
use app\models\LoyaltyProgramsSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LoyaltyProgramsController implements the CRUD actions for LoyaltyPrograms model.
 */
class LoyaltyProgramsController extends AdminController
{
    public $viewPath = '/admin/loyalty-programs/';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'deletestep' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all LoyaltyPrograms models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LoyaltyProgramsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render($this->viewPath . 'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LoyaltyPrograms model.
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
     * Creates a new LoyaltyPrograms model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        # Loyalty programs
        $model = new LoyaltyPrograms();

        #Loyalty programs steps
        $modelSteps = new LoyaltyProgramsSteps();

        $arModels = array($model);
        $arResult = $model->find()->all();
        
        if( !empty($arResult) ){
            $arModels = $arResult;

            # finding programs groups
            $arGroups = [];
            $arTmpGroups = ClientsGroups::getList();
            foreach($arTmpGroups as $arGroup){
                $arGroups[$arGroup['LOYALTY_PROGRAM_ID']][$arGroup['ID']] = $arGroup['NAME'];
            }

            # finding all steps
            $arTmpModelSteps = $modelSteps->find()->all();
            foreach($arTmpModelSteps as $tmpModelStep){
                $modelStepGroupId = $tmpModelStep->getAttribute('LOYALTY_PROGRAM_ID');
                $arModelSteps[$modelStepGroupId][] = $tmpModelStep;
            }
        }
        
        # Save loyalties
        foreach($arModels as $model){
            $arGroups = empty($arGroups) ? [] : $arGroups;

            if( $model->load(Yii::$app->request->post()) ){
                try{
                    $model->save();
                }
                catch(\Exception $e){
                    Yii::trace($e);
                }
            }
        }

        # Save loyalties steps
        if( $modelSteps->load(Yii::$app->request->post()) ){
            try{
                $arNewProps = $modelSteps->getAttributes();
                if( !empty($arNewProps['ID']) ){
                    $modelSteps = $modelSteps->findOne(['ID' => $modelSteps->ID]);
                    $modelSteps->TOTAL = $arNewProps['TOTAL'];
                    $modelSteps->CLIENT_GROUP_ID = $arNewProps['CLIENT_GROUP_ID'];
                }
                
                $modelSteps->save(true);
            }
            catch(\Exception $e){
                Yii::info($e, 'flower');
            }
        }
        
    
        return $this->render($this->viewPath . 'create', [
            'arModels' => $arModels,
            'arModelSteps' => $arModelSteps,
            'modelSteps' => $modelSteps,
            'arGroups' => $arGroups,
        ]);
    }

    /**
     * Updates an existing LoyaltyPrograms model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id = 0)
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
     * Finds the LoyaltyPrograms model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LoyaltyPrograms the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LoyaltyPrograms::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
