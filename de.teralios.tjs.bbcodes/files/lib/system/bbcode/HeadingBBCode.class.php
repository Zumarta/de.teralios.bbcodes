<?php
// namespace
namespace wcf\system\bbcode;

// imports
use wcf\system\jumpmark\JumpMarkMap;
use wcf\system\WCF;

/**
 * Parse heading and subheading tag.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	GNU General Public License <http://opensource.org/licenses/gpl-license.php>
 * @package	de.teralios.tjs.bbcodes
 */
class HeadingBBCode extends AbstractBBCode {
	/**
	 * Array with jump marks for checking jump marks.
	 * 
	 * @var	array<string>
	 */
	protected static $jumpMarks = array();

	/**
	 * @see \wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		$tag = mb_strtolower($openingTag['name']);
		switch ($tag) {
			case 'heading':
				$tag = 'h2';
				$css = ' class="headingBBCode"';
				break;
			default:
				$tag = 'h3';
				$css = ' class="subheadingBBCode"';
				break;
		}
		
		if ($parser->getOutputType() == 'text/html' && !empty($openingTag['attributes'][0])) {
			$jumpMark = $openingTag['attributes'][0];
			$jumpMark = 'a-'.self::jumpMarkExists($jumpMark, $jumpMark);
			$jumpMarkID = ' id="'.$jumpMark.'"';
		}
		else {
			$jumpMark = '';
			$jumpMarkLink = '';
			$jumpMarkID = '';
		}
		
		$return = '';
		
		// heading and subheading tag html.
		if ($parser->getOutputType() == 'text/html') {
			if (!empty($jumpMark)) {
				switch ($tag) {
					case 'h2':
						JumpMarkMap::getInstance()->addJumpMark($jumpMark, $content);
						break;
					case 'h3':
						JumpMarkMap::getInstance()->addJumpMark($jumpMark, $content, true);
						break;
				}
			}
			
			$return = '<'.$tag.$css.$jumpMarkID.'>'.$content.'</'.$tag.'>';
		}
		// heading and subheading in simpleified-html.
		else if ($parser->getOutputType('text/simplified-html')) {
			switch ($openingTag['name']) {
				case 'heading':
					$return = '--- '.$content.' ---<br />';
					break;
				default:
					$return = '-- '.$content.' --<br />';
					break;
			}
		}
		
		// return
		return $return;
	}

	/**
	 * Check given jumpmark and create a new, if jumpmark exists.
	 * 
	 * @param	string		$jumpMark
	 * @param	string		$oldJumpMark
	 * @param	number		$counter
	 * @return	string
	 */
	protected static function jumpMarkExists($jumpMark, $oldJumpMark, $counter = 1) {
		if (isset(self::$jumpMarks[$jumpMark])) {
			$newJumpMark = (($oldJumpMark == $jumpMark) ? $jumpMark : $oldJumpMark).'_'.$counter;
			$counter++;
			return self::jumpMarkExists($newJumpMark, $oldJumpMark, $counter);
		}
		
		self::$jumpMarks[$jumpMark] = $jumpMark;
		return $jumpMark;	
	}
}