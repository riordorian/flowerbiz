<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CronController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionSendEverydaySms()
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
