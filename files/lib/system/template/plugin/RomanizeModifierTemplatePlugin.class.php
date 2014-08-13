<?php
namespace wcf\system\template\plugin;

use wcf\util\TeraBBCodeUtil;

class RomanizeModifierTemplatePlugin implements IModifierTemplatePlugin {
	/**
	 * @see \wcf\system\template\plugin\IModifierTemplatePlugin::execute()
	 */
	public function execute($tagArgs, \wcf\system\template\TemplateEngine $tplObj) {
		$integer = intval($tagArgs[0]);
		return TeraBBCodeUtil::romanizeInteger($integer);
	}
}