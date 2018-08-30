<? namespace app\controllers\rest;

use app\models\rest\Sms;
use yii\rest\ActiveController;

class SmsController extends ActiveController
{
	public $modelClass = 'app\models\User';

	public function actionSendEventsInfo()
	{
		$obModel = new Sms();
		$obModel->sendEverydaySms();
	}
}