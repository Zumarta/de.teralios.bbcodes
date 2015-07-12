<?php
namespace wcf\system\directory\entry;

// imports
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Basic class for a directory entry.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014-2015 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 * @deprecated
 */
class Entry {
	/**
	 * Jump mark element. (Used in id-Tags)
	 * @var string
	 */
	protected $anchor = '';
	
	/**
	 * Title 
	 * @var string
	 */
	protected $title = '';
	
	/**
	 * Base link for jumpmark
	 * @var	string
	 */
	protected $shareLink = '';
	
	/**
	 * Canocial URL.
	 * @var	string
	 */
	protected static $canocialUrl = '';
	
	/**
	 * Creates JumpMark object.
	 * 
	 * @param	string	$jumpMark
	 * @param	string	$title
	 */
	public function __construct($anchor, $title) {
		$this->anchor = $anchor;
		$this->title = $title;
	}
	
	/**
	 * Return link with anchor for share it.
	 * 
	 * @return string
	 */
	public function getShareLink() {
		$link = '#'.$this->anchor;
		if (!empty($this->shareLink)) {
			$link = $this->shareLink.$link;
		}
		else if (!empty(static::$canocialUrl)) {
			$link = static::$canocialUrl.$link;
		}
		else {
			$link = static::getRequestURI().$link;
		}
		
		return $link;
	}
	
	/**
	 * Return Anchor for current site.
	 *
	 * @return string
	 */
	public function getAnchorLink() {
		return static::getRequestURI().'#'.$this->anchor;
	}
	
	/**
	 * Return jumpmark.
	 *
	 * @return string
	 */
	public function getJumpMark() {
		return $this->anchor;
	}
	
	/**
	 * Return title for jump mark/anchor.
	 * 
	 * @return	string
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * Set base link.
	 *
	 * @param	string	$shareLink
	 */
	public function setShareLink($shareLink, $isHTMLEncoded = false) {
		$this->shareLink = StringUtil::trim($shareLink);
		
		if ($isHTMLEncoded == true) {
			$this->shareLink = StringUtil::decodeHTML($this->shareLink);
		}
	}
	
	/**
	 * Set a canocial url.
	 *
	 * @param	string		$canocialUrl
	 */
	public static function setCanocialUrl($canocialUrl) {
		static::$canocialUrl = StringUtil::trim($canocialUrl);
	}
	
	/**
	 * Returns specific request uri.
	 * @return string
	 */
	public static function getRequestURI() {
		if (URL_OMIT_INDEX_PHP && !URL_LEGACY_MODE) {
			$link = str_replace(WCF::getTPL()->get('baseHref').'?', WCF::getTPL()->get('baseHref'), WCF::getRequestURI());
			$pos = strpos($link, '&');
			if ($pos > 0) $link = substr_replace($link, '?', $pos, 1);
			
			return $link;
		}
		else if (URL_LEGACY_MODE) {
			return WCF::getRequestURI();
		}
		else if (!stristr(WCF::getRequestURI(), 'index.php')) {
			return str_replace(WCF::getTPL()->get('baseHref'), WCF::getTPL()->get('baseHref').'index.php', WCF::getRequestURI());
		}
		else {
			return WCF::getRequestURI();
		}
	}
	
	/**
	 * Returns anchor.
	 * 
	 * @return string
	 */
	public function __toString() {
		return $this->anchor;
	}
}
