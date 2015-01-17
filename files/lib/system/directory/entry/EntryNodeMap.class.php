<?php
namespace wcf\system\directory\entry;

// imports
use wcf\system\copyright\TeraliosBBCodesCopyright;
use wcf\system\SingletonFactory;
use wcf\system\WCF;
use wcf\util\JSON;

/**
 * Maps of jumpmarks given from heading/subheading bbcode.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class EntryNodeMap extends SingletonFactory implements \Iterator, \Countable {
	
	/**
	 * Main jump marks. 
	 * @var array<\wcf\system\jumpmarks\JumpMarkMainNode>
	 */
	protected $entries = array();
	
	/**
	 * Index for \Iterator.
	 * @var	number
	 */
	protected $index = 0;
	
	/**
	 * Counter for setting jump marks.
	 * @var	number
	 */
	protected $counter = 0;
	
	/**
	 * Current Counter for jump marks.
	 * @var number
	 */
	protected $currentCounter = 0;
	
	/**
	 * Is copyright called?
	 * @var	boolean
	 */
	protected $copyrightCalled = false;
	
	/**
	 * @see \wcf\system\SingletonFactory::init()
	 */
	protected function init() {
		WCF::getTPL()->assign('directory', $this);
	}
	
	/**
	 * Add a jump mark to jump mark map.
	 * 
	 * @author Teralios
	 * @param	string		$jumpMark
	 * @param	string		$title
	 * @param	boolean		$isSubMark
	 */
	public function addEntry($jumpMark, $title, $isSubMark = false) {
		$entry = new Entry($jumpMark, $title);
		
		// sub jump mark is given and no main jumpmark exists.
		if ($isSubMark == true && empty($this->entries)) {
			$this->entries[$this->counter] = new EntryMainNode(); // create a dummy jump mark.
			$this->entries[$this->counter]->setSubEntry($entry);
			$this->currentCounter = $this->counter;
			$this->counter++;
		}
		// sub jump mark is given and a main jump mark exists.
		else if ($isSubMark == true) {
			$this->entries[$this->currentCounter]->setSubEntry($entry);
		}
		// main jumpmark is given.
		else {
			$this->entries[$this->counter] = new EntryMainNode($entry);
			$this->currentCounter = $this->counter;
			$this->counter++;
		}
		
		return $entry;
	}
	
	/**
	 * Clear jumpmark map.
	 */
	public function clearMap() {
		$this->entries = array();
	}
	
	/**
	 * Return Jumpmarks as json string.
	 * 
	 * @return string
	 */
	public function getJSON() {
		return JSON::encode($this->entries);
	}
	
	/**
	 * Return true if jump marks exists.
	 * 
	 * @return boolean
	 */
	public function hasEntries() {
		TeraliosBBCodesCopyright::callCopyright();
		
		return ($this->count() > 0) ? true : false;
	}

	/**
	 * @see Iterator::current()
	 */
	public function current() {
		return $this->entries[$this->index];
	}
	
	/**
	 * @see Countable::count()
	 */
	public function count() {
		return count($this->entries);
	}

	/**
	 * @see Iterator::next()
	 */
	public function next() {
		++$this->index;
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
}