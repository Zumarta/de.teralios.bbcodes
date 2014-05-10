<?php
namespace wcf\system\teralios;

use wcf\system\WCF;
use wcf\util\StringUtil;

final class BBCodeCopyright {
	const DISPLAY_DEV_NOTE = 3;
	private static $key = 'c648642a7a0e68faaebf74f03b81929634872be2';
	private static $counter = 0;
	
	public static function count() {
		if (static::$counter > BBCodeCopyright::DISPLAY_DEV_NOTE) {
			return;
		}
		else {
			static::$counter++;
			if (static::$counter >= BBCodeCopyright::DISPLAY_DEV_NOTE && (!defined('TJS_BBCODE_NO_DEV_NOTE') || StringUtil::getHash(TJS_BBCODE_NO_DEV_NOTE) == static::$key)) {
				WCF::getTPL()->assign('tjsShowDevNote', true);
			}
		}
	}
}