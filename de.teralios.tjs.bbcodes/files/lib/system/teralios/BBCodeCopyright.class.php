<?php
namespace wcf\system\teralios;

use wcf\system\WCF;
use wcf\util\StringUtil;

final class BBCodeCopyright {
	const DISPLAY_DEV_NOTE = 3;
	private static $key = '1b0d911514cc24c30a65918a6d6573d45e6da006';
	private static $counter = 0;
	private static $copyrightKey = null;
	
	public static function count() {
		if (static::$counter > BBCodeCopyright::DISPLAY_DEV_NOTE) {
			return;
		}
		else {
			static::$counter++;
			if (static::$counter >= BBCodeCopyright::DISPLAY_DEV_NOTE && (empty(static::$copyrightKey) || static::$copyrightKey != static::$key)) {
				WCF::getTPL()->assign('tjsShowDevNote', true);
			}
		}
	}
	
	public static function setKey(CopyrightKey $key) {
		static::$copyrightKey = $key;
	}
}