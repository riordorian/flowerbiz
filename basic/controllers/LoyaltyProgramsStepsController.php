<?php

namespace app\controllers;

use app\models\LoyaltyProgramsSteps;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * LoyaltyProgramsStepsController implements the CRUD actions for LoyaltyProgramsSteps model.
 */
class LoyaltyProgramsStepsController extends Controller
{
    /**
     * Controller layout
     * @var string
     */
    public $layout = 'admin.php';

    /**
     * Main body class
     * @var string
     */
    public $bodyClass = 'animated_fill-none';

    /**
     * List items count
     * @var string
     */
    public $listCount = '';

    /**
     * Boolean param, fix heading on page or not
     * @var string
     */
    public $fixHeading = 'false';

    
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
     * Deletes an existing LoyaltyProgramsSteps model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $bDeleted = $this->findModel($id)->delete();

        $arRes = ['STATUS' => 'ERROR'];
        if( $bDeleted ){
            $arRes = ['STATUS' => 'SUCCESS'];
        }
        
        return json_encode($arRes);
    }

    /**
     * Finds the LoyaltyProgramsSteps model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LoyaltyProgramsSteps the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LoyaltyProgramsSteps::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
