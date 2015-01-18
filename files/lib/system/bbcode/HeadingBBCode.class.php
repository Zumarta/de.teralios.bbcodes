<?php
namespace wcf\system\bbcode;

// imports
use wcf\system\directory\Directory;
use wcf\system\directory\entry\Entry;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Parse heading and subheading tag.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class HeadingBBCode extends AbstractBBCode {
	/**
	 * Array with jump marks for checking jump marks.
	 * @var	array<string>
	 */
	protected static $jumpMarks = array();
	
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
			$jumpMark = (isset($openingTag['attributes'][0])) ? StringUtil::trim($openingTag['attributes'][0]) : '';
			$noIndex = boolval($openingTag['attributes'][1]);
			if (BBCODES_HEADLINE_AUTOMARK == 1 && empty($jumpMark)) {
				$jumpMark = substr(md5($content), 0, 10);
			}
			else {
				$jumpMark = '';
			}
			
			if (!empty($jumpMark)) {
				$jumpMark = sprintf(static::$jumpMarkPrefix, static::jumpMarkExists($jumpMark, $jumpMark));
				
				if ($noIndex != true) {
					$jumpMark = Directory::getInstance()->addEntry($jumpMark, StringUtil::decodeHTML($content), (($tag == 'heading') ? false : true));
				}
				else {
					$jumpMark = new Entry($jumpMark, StringUtil::decodeHTML($content));
				}
			}
			
			WCF::getTPL()->assign(array(
				'hsTag' => $tag,
				'hsEntry' => $jumpMark,
				'hsHeading' => $content,
				'hsLinkTitle' => StringUtil::stripHTML($content)
			));
			
			return WCF::getTPL()->fetch('headingBBCode');
		}
		// heading and subheading in simpleified-html.
		else if ($parser->getOutputType('text/simplified-html')) {
			switch ($tag) {
				case 'h1':
					$return = '--- '.$content.' ---<br />';
					break;
				default:
					$return = '-- '.$content.' --<br />';
					break;
			}
			
			return $return;
		}
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