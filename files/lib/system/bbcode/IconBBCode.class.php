<?php
// namespace
namespace wcf\system\bbcode;

// imports
use wcf\system\copyright\TeraliosBBCodesCopyright;
use wcf\util\StringUtil;

/**
 * Icon bbcode.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014-2015 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class IconBBCode extends AbstractBBCode {
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		// copyright
		TeraliosBBCodesCopyright::callCopyright();
		
		$icon = (isset($openingTag['attributes'][0])) ? StringUtil::trim($openingTag['attributes'][0]) : 'fa-rebel'; // Yes, Rebel icon as default icon! ;)
		$float = (isset($openingTag['attributes'][1])) ? mb_strtolower(StringUtil::trim($openingTag['attributes'][1])) : 'none';
		$size = (isset($openingTag['attributes'][2])) ? $openingTag['attributes'][2] : 16;
		
		return '<span class="fa icon'.$size.' '.$icon.' '.(($float != 'none') ? 'teralios'.ucfirst($float) : '').'"></span>';
	}
}