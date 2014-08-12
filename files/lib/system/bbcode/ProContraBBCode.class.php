<?php
namespace wcf\system\bbcode;

// imports
use wcf\system\WCF;
use wcf\system\copyright\TeraliosBBCodesCopyright;
use wcf\util\StringUtil;

/**
 * Pro and Contra BBCode for the wcf2.0.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	GNU Lesser General Public License v3.0 <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package de.teralios.tjs.bbcodes
 */
class ProContraBBCode extends AbstractBBCode {
	const SPLIT_PATTERN = '#\[([+-\\\*])\]#';

	/**
	 * @see	\wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		$title = (isset($openingTag['attributes'][0])) ? $openingTag['attributes'][0] : WCF::getLanguage()->get('wcf.bbcode.proContra');
		if (isset($openingTag['attributes'][1])) {
			$position = StringUtil::firstCharToUpperCase($openingTag['attributes'][1]);
		}
		else {
			$position = 0;
		}
		
		if (preg_match(self::SPLIT_PATTERN, $content)) {
			// split on [+] [-] or [*]
			$elements = array();
			$elements = preg_split(self::SPLIT_PATTERN, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
			
			// remove first element.
			unset($elements[0]);
			
			// build pairs
			$pairs = array();
			if (!empty($elements)) {
				$i = 1;
				$count = count($elements);
				while ($i < $count) {
					$value = StringUtil::trim($elements[($i + 1)]);
					if (!empty($value) && $value != '<br />') {
						$pairs[] = array('sign' => $elements[$i], 'value' => $value);
					}
					$i =  $i+2;
				}
			}
			
			// build list array
			$points = array('pro' => array(), 'contra' => array(), 'neutral' => array());
			foreach ($pairs as $pair) {
				switch ($pair['sign']) {
					case '+':
						$points['pro'][] = $pair['value'];
						break;
					case '-':
						$points['contra'][] = $pair['value'];
						break;
					case '*':
						$points['neutral'][] = $pair['value'];
						break;
				}
			}
			WCF::getTPL()->assign(array(
				'pcTitle' => $title,
				'pcPoints' => $points,
				'pcPosition' => $position
			));
		}
		else {
			WCF::getTPL()->assign(array(
				'pcTitle' => $title,
				'pcPoints' => array(),
				'pcContent' => $content,
				'pcPosition' => $position
			));
		}
	
		// out put
		if ($parser->getOutputType() == 'text/html') {
			$return = WCF::getTPL()->fetch('proContraBBCodeTag');
			
			// copyright counter.
			TeraliosBBCodesCopyright::callCopyright();
		}
		else {
			$return = WCF::getTPL()->fetch('proContraBBCodeTagSimple');
		}
		
		return $return;
	}
}