<?php
namespace wcf\system\event\listener;

// imports
use wcf\system\event\IEventListener;

/**
 * Remove <br /> from some bbcodes.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class KillBRTagEventListener implements IEventListener {
	public function execute($eventObj, $className, $eventName) {
		$message = $eventObj->message;
		$message = preg_replace('#(<\/(h1|h2|div|dl)>)<!-- removeBR -->[\s]*<br( \/)?>#i', '\\1', $message);
		$eventObj->message = $message;
	}
}
