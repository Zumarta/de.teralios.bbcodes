<?php
// namespace
namespace wcf\system\jumpmark;

// imports
use wcf\system\WCF;

/**
 * Basic class for a jump mark.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	GNU Lesser General Public License v3.0 <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package de.teralios.tjs.bbcodes
 */
class JumpMark {
	/**
	 * Jump mark element. (Used in id-Tags)
	 * 
	 * @var string
	 */
	protected $jumpMark = '';
	
	/**
	 * Title
	 * 
	 * @var string
	 */
	protected $title = '';
	
	/**
	 * Canocial URL.
	 *
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
	 * Return link for jumpmark/anchor.
	 * @return string
	 */
	public function getLink() {
		return ((!empty(static::$canocialUrl)) ? static::$canocialUrl : WCF::getRequestURI()).'#'.$this->jumpMark;
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
	 * @return	string
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * Set a canocial url.
	 *
	 * @param	string		$canocialUrl
	 */
	public static function setCanocialUrl($canocialUrl) {
		static::$canocialUrl = $canocialUrl;
	}
}