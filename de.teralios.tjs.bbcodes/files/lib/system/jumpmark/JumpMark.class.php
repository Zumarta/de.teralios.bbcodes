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
 * @license	GNU General Public License <http://opensource.org/licenses/gpl-license.php>
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
	 * Return link for jump mark/anchor.
	 * @return string
	 */
	public function getLink() {
		return WCF::getRequestURI().'#'.$this->jumpMark;
	}
	
	/**
	 * Return title for jump mark/anchor.
	 * @return	string
	 */
	public function getTitle() {
		return $this->title;
	}
}