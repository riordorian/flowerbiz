<?php

namespace app\controllers;

use \app\models\Clients;
use app\models\ClientsClientsGroups;
use app\models\ClientsClientsTypes;
use app\models\ClientsGroups;
use app\models\ClientsTypes;
use app\models\Orders;
use budyaga\users\models\forms\LoginForm;
use budyaga\users\models\User;
use Yii;

class TerminalController extends \yii\web\Controller
{
    /**
     * @var string
     */
    public $layout = 'terminal';


    /**
     * Show login form or trying to log in
     *
     * @return array|string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionLogin()
    {
        $this->layout = 'terminal-login';
        $arReq = \Yii::$app->getRequest()->getBodyParams();

        if( empty($arReq['CODE']) ){
            return $this->render('login');
        }
        else{
            $userId = (int)$arReq['CODE'];
            $obUser = new LoginForm();
            $obIdentity = User::findIdentity($userId);
            if( empty($obIdentity->email) ){
                echo json_encode(['STATUS' => false]);
                return false;
            }

            $obUser->email = $obIdentity->email;
            $obUser->password = $arReq['CODE'];
            
            $bAuthorized = $obUser->login();
            if( $bAuthorized ){
                echo json_encode(['STATUS' => true]);
            }
            else{
                echo json_encode(['STATUS' => false, 'ERRORS' => $obUser->getErrors()]);
            }
        }
    }


    /**
     * Orders schedule
     * 
     * @return mixed
     */
    public function actionCalendar()
    {
        if( Yii::$app->user->can('terminalWork') === false ){
            Yii::$app->user->logout();
            $this->redirect('/terminal/login/');
        }
        
        $arOrders = Orders::find()
            ->andWhere(['!=', 'TYPE', 'B'])
            ->andWhere(['!=', 'STATUS', 'F'])
            ->asArray()
            ->all();
		$arOrdersSchedule = [];
		foreach($arOrders as $arOrder){
            $class = '';
            
            if( $arOrder['STATUS'] == 'N' ){
                if( time() >= strtotime(date('d.m.Y', strtotime($arOrder['RECEIVING_DATE_START'])) . ' 00:00:00') ){
                    $class = 'bg-danger';
                }
                else{
                    $class = 'bg-warning';
                }
            }

			$arOrdersSchedule[] = [
				'id' => $arOrder['ID'],
				'title' => $arOrder['NAME'],
				'start' => $arOrder['RECEIVING_DATE_START'],
				'end' => $arOrder['RECEIVING_DATE_END'],
				'durationEditable' => false,
				'resourceEditable' => true,
				'description' => $arOrder['COMMENT'],
				'className' => $class,
				'status' => $arOrder['STATUS'],
			];
		}

        return $this->render('calendar',
            ['arOrders' => $arOrdersSchedule]
        );
    }


    /**
     * Getting clients list by phone or name
     * 
     * @throws \yii\base\InvalidConfigException
     */
    public function actionClientsList()
    {
        if( Yii::$app->user->can('terminalWork') === false ){
            Yii::$app->user->logout();
            $this->redirect('/terminal/login/');
        }

        $arReq = \Yii::$app->getRequest()->getBodyParams();
        $arClients = [];

        $arClients = Clients::getClientsByNameOrPhone($arReq['QUERY']);


        echo json_encode($arClients);
    }


    /**
     * Adding new client
     *
     * @return string
     */
    public function actionClientAdd()
    {
        $obClients = new Clients();
        if( $obClients->load(Yii::$app->request->post()) && $obClients->save(true) ){
           return '';
        }
        else{
            $this->layout = 'empty';
            $arCTypes = ClientsTypes::getFilterValues();

            return $this->render('_client-form.php', [
                'model' => $obClients,
                'modelCTypes' => new ClientsTypes(),
                'modelCCTypes' => new ClientsClientsTypes(),
                'modelCCGroups' => new ClientsClientsGroups(),
                'arCTypes' => ClientsTypes::getFilterValues(),
                'arCGroups' => ClientsGroups::getFilterValues(),
                'bDefCTypeChecked' => current(array_keys($arCTypes)),
                'nameLabel' => $obClients->getAttributeLabel('NAME')
            ]);
        }
    }
}