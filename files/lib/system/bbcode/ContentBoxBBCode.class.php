<?php
namespace wcf\system\bbcode;

// imports
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Parse box bbcode.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class ContentBoxBBCode extends AbstractBBCode {
	/**
	 * @see \wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag,\wcf\system\bbcode\BBCodeParser $parser) {
		$title = (isset($openingTag['attributes'][0])) ? StringUtil::trim($openingTag['attributes'][0]) : '';
		$position = (isset($openingTag['attributes'][1])) ? StringUtil::toLowerCase($openingTag['attributes'][1]) : '';
		$size = (isset($openingTag['attributes'][2])) ? $openingTag['attributes'][2] : 0;
		
		// size settings.
		if ($size == 0 && ($position == 'left' || $position == 'right')) {
			$size = 2;
		}
		else if ($size == 0) {
			$size = 4;
		}
		
		if ($parser->getOutputType() == 'text/simplified-html') {
			if (!empty($title)) {
				$return = '<br />----( '.$title.' )----<br />';
			}
			else {
				$return = '<br />--------<br />';
			}
			$return .= $content;
			$return .= '<br />--------<br />';
			return $return;
		}
		else if ($parser->getOutputType() == 'text/html') {
			WCF::getTPL()->assign(array(
				'boxTitle' => $title,
				'boxPosition' => $position,
				'boxSize' => $size,
				'boxContent' => $content
			));
			
			return WCF::getTPL()->fetch('contentBoxBBCode', 'wcf');
		}
	}
}