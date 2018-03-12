<?php

namespace app\controllers;


use app\models\ClientsEvents;
use yii\web\Controller;

class ClientsEventsController extends Controller
{
    /**
     * Delete the ClientsEvents elem by id
     * @param $id - ClientsEvents row id
     */
    public function actionDelete($id)
    {
        $bRes = $this->findModel($id)->delete();
        if( $bRes ){
            echo json_encode(['STATUS' => 'SUCCESS']);
        }
    }


    /**
     * Finds the ClientsEvents model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClientsEvents the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClientsEvents::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
