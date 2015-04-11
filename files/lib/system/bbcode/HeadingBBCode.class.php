<?php
namespace wcf\system\bbcode;

// imports
use wcf\system\copyright\TeraliosBBCodesCopyright;
use wcf\system\directory\Directory;
use wcf\system\directory\entry\Entry;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Parse heading and subheading tag.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014-2015 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class HeadingBBCode extends AbstractBBCode {
	/**
	 * Array with jump marks for checking jump marks.
	 * @var	array<string>
	 */
	protected static $anchors = array();
	
	/**
	 * Prefix for jump marks.
	 * @var	string
	 */
	protected static $anchorPrefix = 'a-%s';

	/**
	 * @see \wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		// copyright
		TeraliosBBCodesCopyright::callCopyright();
		
		$tag = mb_strtolower($openingTag['name']);

		// heading and subheading tag html.
		if ($parser->getOutputType() == 'text/html') {
			$anchor = (isset($openingTag['attributes'][0])) ? StringUtil::trim($openingTag['attributes'][0]) : '';
			$noIndex = (isset($openingTag['attributes'][1])) ? $openingTag['attributes'][1] : false; // boolval is php 5.5
			$noIndex = ($noIndex == 1) ? true : false;
			if (BBCODES_HEADLINE_AUTOMARK == 1 && empty($anchor)) {
				$anchor = substr(md5($content), 0, 10);
			}
			else if (empty($anchor)) {
				$anchor = '';
			}
			
			if (!empty($anchor)) {
				$anchor = sprintf(static::$anchorPrefix, static::anchorExists($anchor, $anchor));
				
				if ($noIndex != true) {
					$anchor = Directory::getInstance()->addEntry($anchor, StringUtil::decodeHTML($content), (($tag == 'h1') ? true : false));
				}
				else {
					$anchor = new Entry($anchor, StringUtil::decodeHTML($content));
				}
			}
			
			WCF::getTPL()->assign(array(
				'hsTag' => $tag,
				'hsEntry' => $anchor,
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
	 * @param	string		$anchor
	 * @param	string		$oldAnchor
	 * @param	number		$counter
	 * @return	string
	 */
	protected static function anchorExists($anchor, $oldAnchor, $counter = 1) {
		if (isset(self::$anchors[$anchor])) {
			$newJumpMark = (($oldAnchor == $anchor) ? $anchor : $oldAnchor).'_'.$counter;
			$counter++;
			return self::anchorExists($newJumpMark, $oldAnchor, $counter);
		}
		
		self::$anchors[$anchor] = $anchor;
		return $anchor;	
	}
}