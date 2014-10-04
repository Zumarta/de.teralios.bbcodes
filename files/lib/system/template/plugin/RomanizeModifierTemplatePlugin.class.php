<?php
namespace wcf\system\template\plugin;

// imports
use wcf\util\TeraBBCodeUtil;

/**
 * Add romanize modification to template engine.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class RomanizeModifierTemplatePlugin implements IModifierTemplatePlugin {
	/**
	 * @see \wcf\system\template\plugin\IModifierTemplatePlugin::execute()
	 */
	public function execute($tagArgs, \wcf\system\template\TemplateEngine $tplObj) {
		$integer = intval($tagArgs[0]);
		return TeraBBCodeUtil::romanizeInteger($integer);
	}
}