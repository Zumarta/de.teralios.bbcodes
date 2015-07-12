<?php
namespace wcf\system\bbcode;

// imports
use wcf\system\bbcode\BBCodeParser;
use wcf\system\copyright\TeraliosBBCodesCopyright;
use wcf\system\directory\Directory;
use wcf\system\directory\entry\Entry;
use wcf\system\WCF;
use wcf\util\ArrayUtil;
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
	
	protected $anchor = '';
	protected $noIndex = false;

	/**
	 * @see \wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		// copyright
		TeraliosBBCodesCopyright::callCopyright();
		
		$tag = mb_strtolower($openingTag['name']);

		// heading and subheading tag html.
		if ($parser->getOutputType() == 'text/html') {
			
			// map attributes
			$this->mapAttributes($openingTag);
			
			// assign attributes
			$anchor = $this->anchor;
			$noIndex = $this->noIndex;
			
			// check anchor and set automark
			if (BBCODES_HEADLINE_AUTOMARK == 1 && empty($anchor)) {
				$anchor = substr(md5($content), 0, 10);
			}
			else if (empty($anchor)) {
				$anchor = '';
			}
			
			// check anchor
			if (!empty($anchor)) {
				$anchor = sprintf(static::$anchorPrefix, static::anchorExists($anchor, $anchor));
				
				if ($noIndex != true) {
					$anchor = Directory::getInstance()->addEntry($anchor, StringUtil::decodeHTML($content), (($tag == 'h1') ? true : false));
				}
				else {
					$anchor = new Entry($anchor, StringUtil::decodeHTML($content));
				}
			}
			
			// assign to template
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
	 * Map attributes.
	 * @param	array	$attributes
	 */
	protected function mapAttributes($openingTag) {
		// reset attributes
		$this->anchor = '';
		$this->noIndex = false;
		
		if (isset($openingTag['attributes'])) {
			$attributes = ArrayUtil::trim($openingTag['attributes']);
			
			// first is no index
			if (isset($attributes[0]) && is_numeric($attributes[0])) {
				$this->noIndex = $attributes[0];
				
				if (isset($attributes[1]) && preg_match('#^[a-zA-Z0-9_]$#', $attributes[1])) {
					$this->anchor = $attributes[1];
				}
			}
			// first is anchor
			else if (isset($attributes[0]) && preg_match('#^[a-zA-Z0-9_]$#', $attributes[0])) {
				$this->anchor = $attributes[1];
				
				if (isset($attributes[0]) && is_numeric($attributes[0])) {
					$this->noIndex = $attributes[0];
				}
			}
			
			$this->noIndex = ($this->noIndex == 1) ? true : false;
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