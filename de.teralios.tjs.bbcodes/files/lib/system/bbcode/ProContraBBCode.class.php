<?php
// namespace
namespace wcf\system\bbcode;

// imports
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Pro and Contra BBCode for the wcf2.0.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	GNU General Public License <http://opensource.org/licenses/gpl-license.php>
 * @package de.teralios.tjs.bbcodes
 */
class ProContraBBCode extends AbstractBBCode {
	const PATTERN = '#\[([+-\\\*])\]#';

	/**
	 * @see	\wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		$title = (isset($openingTag['attributes'][0])) ? $openingTag['attributes'][0] : WCF::getLanguage()->get('wcf.bbcode.proContra');
		if (preg_match(self::PATTERN, $content)) {
			// split on [+] [-] or [*]
			$elements = array();
			$elements = preg_split('#\[([+-\\\*])\]#', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
			
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
						$pairs[] = array('sign' => $elements[$i], 'value' => $elements[($i + 1)]);
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
				'title' => $title,
				'points' => $points
			));
			$return = WCF::getTPL()->fetch('proContraBBCodeTag');
		}
		else {
			// no valid list
			$return = $openingTag['source'].$content.$closingTag['source'];
		}
		
		return $return;
	}
}