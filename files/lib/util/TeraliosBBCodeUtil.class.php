<?php
namespace wcf\util;

class TeraliosBBCodeUtil {
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