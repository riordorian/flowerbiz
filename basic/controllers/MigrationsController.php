<?php

namespace app\controllers;

use app\models\admin\SmsSettings;
use app\models\MoneyAccounts;
use Yii;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\UploadedFile;


class MigrationsController extends PrototypeController
{
	public function action1()
	{
		foreach(Yii::$app->params->arDomains as $domain){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $domain . '/migrations/1/');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
		}

		$arAcc = MoneyAccounts::findOne(['TYPE' => 'BONUS']);
		if( empty($arAcc->ID) ){
			$obAccaunt = new MoneyAccounts();
			$obAccaunt->isNewRecord = true;
			$obAccaunt->setAttributes([
				'NAME' => 'Бонусы',
				'CODE' => 'BONUS',
				'TYPE' => 'BONUS',
				'USE_ON_CASHBOX' => 1,
				'BALANCE' => 0
			]);

			$obAccaunt->save();
		}

	}
}
