<?php
namespace wcf\system\event\listener;

use wcf\system\event\IEventListener;

class KillBRTagEventListener implements IEventListener {
	public function execute($eventObj, $className, $eventName) {
		$message = $eventObj->message;
		$message = preg_replace('#(<\/(h1|h2|div|dl)>)[\s]*<br( \/)?>#i', '\\1', $message);
		$eventObj->message = $message;
	}
}