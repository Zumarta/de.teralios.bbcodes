<?php
namespace wcf\system\bbcode;

// imports
use wcf\util\StringUtil;
use wcf\system\WCF;

/**
 * Parse box bbcode.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	GNU Lesser General Public License v3.0 <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package de.teralios.bbcodes
 */
class BoxBBCode extends AbstractBBCode {
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
				$return = '----( '.$title." )----\n";
			}
			else {
				$return = '--------<br />';
			}
			$return .= $content;
			$return .= "\n--------\n";
		}
		else if ($parser->getOutputType() == 'text/html') {
			WCF::getTPL()->assign(array(
				'boxTitle' => $title,
				'boxPosition' => $position,
				'boxSize' => $size,
				'boxContent' => $content
			));
			
			$return = WCF::getTPL()->fetch('boxBBCode', 'wcf');
		}
		
		return $return;
	}
}