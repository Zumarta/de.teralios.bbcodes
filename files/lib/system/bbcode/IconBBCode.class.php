<?php
// namespace
namespace wcf\system\bbcode;

// imports
use wcf\system\WCF;
use wcf\util\StringUtil;

class IconBBCode extends AbstractBBCode {
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		$icon = (isset($openingTag['attributes'][0])) ? StringUtil::trim($openingTag['attributes'][0]) : 'fa-rebel'; // Yes, Rebel icon as default icon! ;)
		$float = (isset($openingTag['attributes'][1])) ? StringUtil::trim($openingTag['attributes'][1]) : 'none';
		$size = (isset($openingTag['attributes'][2])) ? $openingTag['attributes'][2] : 16;
		
		return '<span class="fa icon'.$size.' '.$icon.'" '.(($float != 'none') ? 'style="float: '.$float.';"' : '').'></span>';
	}
}