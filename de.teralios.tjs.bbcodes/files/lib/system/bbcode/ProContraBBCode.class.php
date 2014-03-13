<?php
// namespace
namespace wcf\system\bbcode;

/**
 * Pro and Contra BBCode for the wcf2.0.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	GNU General Public License <http://opensource.org/licenses/gpl-license.php>
 * @package de.teralios.tjs.bbcodes
 */
class ProContraBBCode extends AbstractBBCode {
	/**
	 * @see	\wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		$content = \wcf\util\StringUtil::trim($content);
		$title = (isset($openingTag['attributes'][0])) ? $openingTag['attributes'][0] : \wcf\system\WCF::getLanguage()->get('wcf.bbcode.proContra');
		
		// initialise data array.
		$points = array('contra' => array(), 'neutral' => array(), 'pro' => array());
		
		// split on \n and <br />
		$elements = explode('<br />', $content);
		if (count($elements) > 0) {
			foreach ($elements AS $point) {
				$point = \wcf\util\StringUtil::trim($point);
				$length = mb_strlen($point);
				if ($length == 0) {
					continue;
				}
				
				$start = $point{0};
				$content = \wcf\util\StringUtil::trim(mb_substr($point, 1));
				$contentLength = $length - 1;
				switch ($start) {
					case '+':
						if ($contentLength > 0) {
							$points['pro'][] = $content;
						}
						break;
					case '-':
						if ($contentLength > 0) {
							$points['contra'][] = $content;
						}
						break;
					default:
						$points['neutral'][] = $point;
				}
			}
		}
	
		if ($parser->getOutputType() == 'text/html') {
			\wcf\system\WCF::getTPL()->assign(array(
				'title' => $title,
				'points' => $points		
			));
			return \wcf\system\WCF::getTPL()->fetch('proContraBBCodeTag');
		}
		else if ($parser->getOutputType() == 'text/simplified-html') {
			$result = $title.":<br />\n";
			if (!empty($points['pro'])) {
				foreach ($points['pro'] AS $point) {
					$result .= '+ '.$point."<br />\n";
				}
			}
			
			if (!empty($points['contra'])) {
				foreach ($points['contra'] AS $point) {
					$result .= '- '.$point."<br />\n";
				}
			}
			
			if (!empty($points['neutral'])) {
				foreach ($points['neutral'] AS $point) {
					$result .= '* '.$point."<br />\n";
				}
			}
			
			return $result;
		}
	}
}