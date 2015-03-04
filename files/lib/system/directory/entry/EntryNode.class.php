<?php
namespace wcf\system\directory\entry;

/**
 * Jump mark node for jump mark map.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014-2015 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class EntryNode {
	/**
	 * Jump mark object.
	 * @var\wcf\system\directory\entry\Entry
	 */
	protected $entry = null;
	
	/**
	 * Create jump mark node.
	 * 
	 * @param \wcf\system\directory\entry\Entry $jumpMark
	 */
	public function __construct(\wcf\system\directory\entry\Entry $entry = null) {
		$this->entry = $entry;
	}
	
	/**
	 * Return jump mark object.
	 * 
	 * @return \wcf\system\jumpmark\JumpMark
	 */
	public function getEntry() {
		return $this->entry;
	}
	
	/**
	 * Return true if a jump mark exists in node.
	 * 
	 * @return boolean
	 */
	public function existEntry() {
		return ($this->entry === null) ? false : true;
	}
}