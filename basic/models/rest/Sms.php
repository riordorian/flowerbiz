<?

namespace app\models\rest;


use app\models\admin\SmsSettings;
use app\models\ClientsEvents;
use app\models\SMSRU;

class Sms
{
	/**
	 * Method change the history row UF_STATUS field value by row ID and status XML_CODE
	 *
	 * @param $arParams - array of action params
	 *
	 * @return array
	 */
	public function sendEverydaySms($arParams = [])
	{
		$arSmsSettings = SmsSettings::findOne(['ID' => 1])->toArray();

		if( $arSmsSettings['ACTIVE'] == 1 && !empty($arSmsSettings['API_ID']) ){
			$arEvents = ClientsEvents::find()
				->where(['EVENT_DATE' => date('Y-m-d', strtotime('+1 day'))])
				->select(['PHONE' => 'clients.PHONE', 'EVENT' => 'events.NAME',  'RECIPIENT' => 'gift_recipients.NAME'])
				->leftJoin('clients', 'clients.ID=clients_events.CLIENT_ID')
				->leftJoin('events', 'events.ID=clients_events.EVENT_ID')
				->leftJoin('gift_recipients', 'gift_recipients.ID=clients_events.GIFT_RECIPIENT_ID')
				->asArray()
				->all();

			if( !empty($arEvents) ){
				$obData = new \stdClass();
				$obData->multiple = [];
				foreach($arEvents as $arEvent){
					$obSms = new SMSRU($arSmsSettings['API_ID']);
					$obData->multi[$arEvent['PHONE']] = 'Завтра у вас событие - ' . $arEvent['RECIPIENT'] . ' - ' . $arEvent['EVENT'] . '. Не забудьте купить букет';
				}

				$obSms->send_one($obData);
			}
		}
	}
}