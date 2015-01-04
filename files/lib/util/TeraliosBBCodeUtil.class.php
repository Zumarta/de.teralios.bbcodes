<?php
namespace wcf\util;

/**
 * Usefull functionts for bbcodes.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class TeraliosBBCodeUtil {
	/**
	 * Parse old bbcode-tags to the new.
	 *
	 * @param	string		$message
	 * @return	mixed
	 */
	public static function parseToNew($message) {
		// contentbox to cbox
		$message = str_ireplace('[contentbox', '[cbox', $message);
		$message = str_ireplace('[/contentbox]', '[/cbox]', $message);
		
		// heading and subheading
		$message = str_ireplace('[heading', '[h1', $message);
		$message = str_ireplace('[/heading', '[/h1]', $message);
		$message = str_ireplace('[subheading', '[h2', $message);
		$message = str_ireplace('[/subheading]', '[/h2]', $message);
		
		// footnotes
		$message = str_ireplace('[footnote', '[fn', $message);
		$message = str_ireplace('[footnotecontent', '[fnc', $message);
		$message = str_ireplace('[/footnote]', '[/fn]', $message);
		$message = str_ireplace('[/footnotecontent]', '[/fnc]', $message);
		
		// pro contra
		$message = str_ireplace('[procontra', '[pclist', $message);
		$message = str_ireplace('[/procontra]', '[/pclist]', $message);
		
		return $message;
	}
}