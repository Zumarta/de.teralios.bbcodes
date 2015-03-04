<?php
namespace wcf\system\directory\entry;

/**
 * Jump mark main node.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014-2015 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class EntryMainNode extends EntryNode implements \Iterator, \Countable {
	/**
	 * Sub jump marks.
	 * @var array<\wcf\system\jumpmark\JumpMarkNode>
	 */
	protected $entries = array();
	
	/**
	 * Index for \Iterator.
	 * @var	number
	 */
	protected $index = 0;
	
	/**
	 * Set a sub JumpMark.
	 * 
	 * @param \wcf\system\jumpmark\JumpMark $jumpMark
	 */
	public function setSubEntry(\wcf\system\directory\entry\Entry $jumpMark) {
		$this->entries[] = new EntryNode($jumpMark);
	}
	
	/**
	 * Returns true if the main node has sub jump marks.
	 * 
	 * @return boolean
	 */
	public function hasEntries() {
		return ($this->count() > 0) ? true : false;
	}
	
	/**
	 * @see Iterator::current()
	 */
	public function current() {
		return $this->entries[$this->index];
	}

	/**
	 * @see Iterator::next()
	 */
	public function next() {
		$this->index++;
	}

	/**
	 * @see Iterator::key()
	 */
	public function key() {
		return $this->index;
	}

	/**
	 * @see Iterator::valid()
	 */
	public function valid() {
		return isset($this->entries[$this->index]);
	}

	/**
	 * @see Iterator::rewind()
	 */
	public function rewind() {
		$this->index = 0;
	}

	/**
	 * @see Countable::count()
	 */
	public function count() {
		return count($this->entries);
	}
}