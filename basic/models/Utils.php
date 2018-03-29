<?
/**
 * Created by PhpStorm.
 * User: riordorian
 * Date: 01.07.17
 * Time: 17:46
 */

namespace app\models;


class Utils
{
	/**
	 * Return parts of date
	 * 
	 * @param string $part
	 *
	 * @return array|mixed
	 */
	public static function getDateArray($part = '')
	{
		$arDate = [];

		$arMonthes = [
			'Январь',
			'Февраль',
			'Март',
			'Апрель',
			'Май',
			'Июнь',
			'Июль',
			'Август',
			'Сентябрь',
			'Октябрь',
			'Ноябрь',
			'Декабрь',
		];

		$arDate['MONTHES'] = array_combine(range(1, 12), $arMonthes);

		$arDays = range(1, 31);
		$arDate['DATES'] = array_combine($arDays, $arDays);

		$arYears = range(date('Y'), 1950);
		$arDate['YEARS'] = array_combine($arYears, $arYears);
		
		return ( !empty($part) && !empty($arDate[$part]) ) ? $arDate[$part] : $arDate;
	}
}