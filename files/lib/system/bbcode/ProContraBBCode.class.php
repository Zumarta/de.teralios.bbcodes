<?php
namespace wcf\system\bbcode;

// imports
use wcf\system\copyright\TeraliosBBCodesCopyright;
use wcf\system\WCF;
use wcf\util\StringUtil;
use wcf\util\TeraBBCodeUtil;

/**
 * Pro and Contra BBCode for the wcf2.0.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.tjs.bbcodes
 */
class ProContraBBCode extends AbstractBBCode {
	const SPLIT_PATTERN = '#\[([+-\\\*])\]#';

	/**
	 * @see	\wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		$title = (isset($openingTag['attributes'][0]) && !empty($openingTag['attributes'][0])) ? $openingTag['attributes'][0] : WCF::getLanguage()->get('wcf.bbcode.proContra');
		$points = array();
		
		// position of the pro contra list.
		if (isset($openingTag['attributes'][1])) {
			$position = StringUtil::firstCharToUpperCase($openingTag['attributes'][1]);
		}
		else {
			$position = 0;
		}
		
		// build array
		if (preg_match(self::SPLIT_PATTERN, $content)) {
			// split on [+] [-] or [*]
			$elements = array();
			$elements = preg_split(self::SPLIT_PATTERN, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
			
			// remove first element.
			unset($elements[0]);
			
			// build array for points.
			if (!empty($elements)) {
				$i = 1;
				$count = count($elements);
				while ($i < $count) {
					$sign = $elements[$i];
					$value = StringUtil::trim($elements[($i + 1)]);
					
					// check value, when is not empty, add.
					if (!empty($value) && $value != '<br />') {
						if (!isset($points[$sign])) {
							$points[$sign] = array();
						}
						$points[$sign][] = $value;
					}
					
					// current index + 2
					$i =  $i+2;
				}
			}
		}
		
		// output
		if (empty($points)) {
			return '[procontra]'.$content.'[/procontra]';
		}
		else if ($parser->getOutputType() == 'text/html') {
			// copyright counter.
			TeraliosBBCodesCopyright::callCopyright();
			
			// easter egg
			TeraBBCodeUtil::easterEgg();
			
			// add template variables
			WCF::getTPL()->assign(array(
				'pcTitle' => $title,
				'pcPoints' => $points,
				'pcPosition' => $position
			));
			
			return	WCF::getTPL()->fetch('proContraBBCodeTag');
		}
		else if ($parser->getOutputType() == 'text/simplified-html') {
			// no supports simplified html.
			$return = $title."\n";
			$return .= str_repeat('-', mb_strlen($title))."\n";
			foreach ($points AS $sign => $values) {
				$length = count($values);
				if ($length > 0) {
					$length--;
					for ($i = 0; $i <= $length; $i++) {
						$return .= $sign." ".$values[$i]."\n";
					}
				}
			}
			
			return $return;
		}
	}
}