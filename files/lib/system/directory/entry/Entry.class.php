<?php
namespace wcf\system\directory\entry;

// imports
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Basic class for a directory entry.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class Entry {
	/**
	 * Jump mark element. (Used in id-Tags)
	 * @var string
	 */
	protected $jumpMark = '';
	
	/**
	 * Title 
	 * @var string
	 */
	protected $title = '';
	
	/**
	 * Base link for jumpmark
	 * @var	string
	 */
	protected $baseLink = '';
	
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
	public function __construct($jumpMark, $title) {
		$this->jumpMark = $jumpMark;
		$this->title = $title;
	}
	
	/**
	 * Return link with anchor for share it.
	 * 
	 * @return string
	 */
	public function getLink() {
		$link = '#'.$this->jumpMark;
		if (!empty($this->baseLink)) {
			$link = $this->baseLink.$link;
		}
		else if (!empty(static::$canocialUrl)) {
			$link = static::$canocialUrl.$link;
		}
		else {
			$link = WCF::getRequestURI().$link;
		}
		
		return $link;
	}
	
	/**
	 * Return Anchor for current site.
	 *
	 * @return string
	 */
	public function getAnchor() {
		return WCF::getRequestURI().'#'.$this->jumpMark;
	}
	
	/**
	 * Return jumpmark.
	 *
	 * @return string
	 */
	public function getJumpMark() {
		return $this->jumpMark;
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
	 * @param	string	$baseLink
	 */
	public function setBaseLink($baseLink) {
		$this->baseLink = StringUtil::trim($baseLink);
	}
	
	/**
	 * Set a canocial url.
	 *
	 * @param	string		$canocialUrl
	 */
	public static function setCanocialUrl($canocialUrl) {
		static::$canocialUrl = StringUtil::trim($canocialUrl);
	}
	
	public function __toString() {
		return $this->jumpMark;
	}
}