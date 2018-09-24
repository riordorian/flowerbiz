<?php

namespace app\controllers;

use app\models\admin\SmsSettings;
use Yii;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\UploadedFile;


class AdminController extends PrototypeController
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

    public $viewPath = '/admin/';

	public function actionSmsSettings()
	{
		$obModel = new SmsSettings();
		$obSmsSettings = $obModel->findOne(['ID' => 1]);
		$obModel = empty($obSmsSettings) ? $obModel : $obSmsSettings;

		if ($obModel->load(Yii::$app->request->post()) ) {
			try{
				$obModel->save();
			}
			catch(\Exception $e){
				Yii::trace($e->getMessage(), 'flower');
			}
		}

		return $this->render($this->viewPath . '/sms-settings/index', [
			'obModel' => $obModel
		]);
	}


	public function actionSms()
	{

		$arDomains = [
			'floradesign.flowershop.pro',

			'debora.flowershop.pro',
			'kmp-kirov.flowershop.pro',
			'kmp-pyatigosrsk.flowershop.pro',
			'9106477400.flowershop.pro',
			'oskol.flowershop.pro'
		];

		foreach($arDomains as $domain){
			try{
				exec('curl -X POST ' . $domain . '/rest/sms/send-events-info/');
			} catch(\Exception $e){
				Yii::trace($e->getMessage(), 'flower');
			}
		}
	}
}
