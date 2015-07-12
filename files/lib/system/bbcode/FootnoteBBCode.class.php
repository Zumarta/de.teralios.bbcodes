<?php
namespace wcf\system\bbcode;

// imports
use wcf\system\bbcode\BBCodeParser;
use wcf\system\copyright\TeraliosBBCodesCopyright;
use wcf\system\footnote\Footnote;
use wcf\system\footnote\FootnoteMap;
use wcf\system\request\RequestHandler;
use wcf\system\WCF;
use wcf\util\ArrayUtil;
use wcf\util\StringUtil;

/**
 * Parse footnotes.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014-2015 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class FootnoteBBCode extends AbstractBBCode {
	/**
	 * Check foot notes for existing.
	 * @var	array<integer>
	 */
	protected static $footnotes = array();
	
	/**
	 * Status for parse footnotes.
	 * @var	boolean
	 */
	protected static $parse = null;
	
	/**
	 * Buffered content for footnotes when footnotecontent is parsed first.
	 * @var    array<string>
	 */
	protected static $footnoteContent = array();
	
	/**
	 * Index for footnotes when now footnotes are parsed to footnotemap.
	 * @var    integer
	 */
	protected static $indexNoParse = 1;
	
	/**
	 * @see \wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		// copyright
		TeraliosBBCodesCopyright::callCopyright();
		
		$content = StringUtil::trim($content);
		
		// check controller for parsing foot notes.
		if (static::$parse == null) {
			static::parseFootnotes();
		}
		
		// footnote and fn parse.
		if ($openingTag['name'] == 'fn') {
			if (self::$parse == true) {
				// no content and no index for content tag: drop footnote.
				$content = StringUtil::trim($content);
				if (empty($content) && !isset($openingTag['attributes'][0])) {
					return '';
				}
				
				// build hash from content or use index for content attribute
				$hash = (!empty($content)) ? StringUtil::getHash($content) : StringUtil::getHash($openingTag['attributes'][0]);
				
				// check footnotes for existing.
				if (!isset(static::$footnotes[$hash])) {
					// check for buffred content.
					if (empty($content) && isset(static::$footnoteContent[$hash])) {
						$content = static::$footnoteContent[$hash];
					}
			
					$footnoteIndex = FootnoteMap::getInstance()->add($content, Footnote::TYPE_BBCODE);
					static::$footnotes[$hash] = $footnoteIndex;
				}
				else {
					$footnoteIndex = static::$footnotes[$hash];
				}
				
				// get index for tag attribute.
				$footnoteTagIndex = Footnote::getTagIndex($footnoteIndex);
			}
			else {
				$footnoteTagIndex = '';
				$footnoteIndex = static::$indexNoParse;
				++static::$indexNoParse;
			}
			
			WCF::getTPL()->assign(array(
				'footnoteTagID' => $footnoteTagIndex,
				'footnoteIndex' => $footnoteIndex
			));
			
			return WCF::getTPL()->fetch('footnoteBBCode');
		}
		// footnotecontent and fnc.
		else if ($openingTag['name'] == 'fnc') {
			if (static::$parse == false) {
				return '';
			}

			$contentIndex = StringUtil::getHash($openingTag['attributes'][0]);
			
			// set content or buffered.
			if (isset(static::$footnotes[$contentIndex])) {
				$index = static::$footnotes[$contentIndex];
				$footnote = FootnoteMap::getInstance()->getFootnote($index);
				if ($footnote != false) {
					$footnote->setText(StringUtil::trim($content), Footnote::TYPE_HTML);
				}
			}
			else {
				static::$footnoteContent[$contentIndex] = $content;
			}
			
			return '';
		}
	}
	
	/**
	 * Check pages and set parse status.
	 */
	public static function parseFootnotes() {
		$request = RequestHandler::getInstance()->getActiveRequest();
		$pageName = StringUtil::toLowerCase($request->getPageName());
		$allowedPages = ArrayUtil::trim(explode("\n", StringUtil::toLowerCase(BBCODES_FOOTNOTE_PARSE_PAGE)));
		
		if (in_array($pageName, $allowedPages)) {
			static::$parse = true;
		}
		else {
			static::$parse = false;
		}
	}
}