<?php
namespace wcf\util;

/**
 * Use full functions for bbcodes.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	GNU Lesser General Public License v3.0 <http://www.gnu.org/licenses/lgpl-3.0.txt>
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
			$romantInteger = $integer;
		}
		
		return $romanInteger;
	}
}