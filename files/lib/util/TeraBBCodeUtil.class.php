<?php
namespace wcf\util;

// imports
use wcf\system\WCF;

/**
 * Use full functions for bbcodes.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class TeraBBCodeUtil {
	public static $romanIntegers = array(
		'I' => 1,
		'IV' => 4,
		'V' => 5,
		'IX' => 9,
		'X' => 10,
		'XL' => 40,
		'L' => 50,
		'XC' => 90,
		'C' => 100,
		'CD' => 400,
		'D' => 500,
		'CM' => 900,
		'M' => 1000
	);
	
	/**
	 * Romaninze a intenger.
	 *
	 * @para	integer		$integer
	 * @return	Ambigous	string
	 */
	public static function romanizeInteger($integer) {
		$romanInteger = '';
		if (is_int($integer)) {
			$romanIntegers = array_reverse(self::$romanIntegers);
			foreach ($romanIntegers AS $sign => $number) {
				while ($integer >= $number) {
					$romanInteger .= $sign;
					$integer = $integer - $number;
				}
			}
		}
		else {
			$romanInteger = $integer;
		}
		
		return $romanInteger;
	}
	
	/**
	 * Yes i know, its not really a secret, but i will add some thing for my dead father.
	 */
	public static function easterEgg() {
		// easter egg to birthday of my father and his date of death.
		$dateTime = DateUtil::getDateTimeByTimestamp(TIME_NOW);
		$date = Dateutil::format($dateTime, 'd-m');
		if ($date == '17-08' || $date == '16-04') {
			WCF::getTPL()->assign('teraEgg', '<a href="http://www.patentbuddy.com/Inventor/Achterrath-Wolf-R/5519409"'.((EXTERNAL_LINK_TARGET_BLANK) ? ' target="_blank"' : '').'><span class="icon32 fa fa-ra"></span></a>');
		}
	}
}