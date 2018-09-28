<? namespace app\controllers\rest;

use app\models\Clients;
use app\models\rest\Sms;
use yii\rest\ActiveController;

class SmsController extends ActiveController
{
	public $modelClass = 'app\models\User';

	public function actionSendEventsInfo()
	{
		$obModel = new Sms();
		try{
			Clients::addEventsBonuses(200);
			Clients::removeEventsBonuses(200);
			$obModel->sendEverydaySms();
		}
		catch(\Exception $e){

		}
	}
}