<?php
namespace wcf\system\bbcode;

// imports
use wcf\system\jumpmark\JumpMarkMap;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Parse heading and subheading tag.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	GNU Lesser General Public License v3.0 <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.teralios.tjs.bbcodes
 */
class HeadingBBCode extends AbstractBBCode {
	/**
	 * Array with jump marks for checking jump marks.
	 * @var	array<string>
	 */
	protected static $jumpMarks = array();
	
	/**
	 * String for automatic generated jump marks.
	 * @var	string
	 */
	protected static $autoMarkPrefix = 'autoMark_%s';
	
	/**
	 * Index of automatic generated jump marks.
	 * @var	integer
	 */
	protected static $autoMarkIndex = 1;
	
	/**
	 * Prefix for jump marks.
	 * @var	string
	 */
	protected static $jumpMarkPrefix = 'a-%s';

	/**
	 * @see \wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		$tag = mb_strtolower($openingTag['name']);
		
		// heading and subheading tag html.
		if ($parser->getOutputType() == 'text/html') {
			if (!empty($openingTag['attributes'][0])) {
				$jumpMark = $openingTag['attributes'][0];
			}
			else if (BBCODES_HEADLINE_AUTOMARK == 1) {
				$jumpMark = sprintf(static::$autoMarkPrefix, static::$autoMarkIndex);
				++static::$autoMarkIndex;
			}
			else {
				$jumpMark = '';
			}
			
			if (!empty($jumpMark)) {
				$jumpMark = sprintf(static::$jumpMarkPrefix, static::jumpMarkExists($jumpMark, $jumpMark));
				$jumpMark = JumpMarkMap::getInstance()->addJumpMark($jumpMark, StringUtil::decodeHTML($content), (($tag == 'heading') ? false : true));
				
			}
			
			WCF::getTPL()->assign(array(
				'hstag' => $tag,
				'hsJumpMark' => $jumpMark,
				'hsHeading' => $content
			));
			
			$return = WCF::getTPL()->fetch('headingBBCode');
		}
		// heading and subheading in simpleified-html.
		else if ($parser->getOutputType('text/simplified-html')) {
			switch ($openingTag['name']) {
				case 'heading':
					$return = '--- '.$content." ---\n";
					break;
				default:
					$return = '-- '.$content." --\n";
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