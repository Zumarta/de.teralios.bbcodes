<?php
namespace wcf\system\teralios;

use wcf\system\WCF;
use wcf\util\StringUtil;

final class BBCodeCopyright {
	const DISPLAY_DEV_NOTE = 5;
	private static $key = '1b0d911514cc24c30a65918a6d6573d45e6da006';
	private static $counter = 0;
	
	public static function count() {
		if (static::$counter > BBCodeCopyright::DISPLAY_DEV_NOTE) {
			return;
		}
		else {
			static::$counter++;
			if (static::$counter >= BBCodeCopyright::DISPLAY_DEV_NOTE && (!defined('TJS_BBCODE_NO_DEV_NOTE') || StringUtil::getHash(TJS_BBCODE_NO_DEV_NOTE) != static::$key)) {
				WCF::getTPL()->assign('tjsShowDevNote', true);
			}
		}
	}
}