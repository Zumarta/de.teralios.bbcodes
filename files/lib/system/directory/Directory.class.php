<?php
namespace wcf\system\directory;

// imports
use wcf\system\copyright\TeraliosBBCodesCopyright;
use wcf\system\directory\entry\Entry;
use wcf\system\directory\entry\EntryMainNode;
use wcf\system\WCF;

/**
 * Directory class
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class Directory  extends SingletonFactory implements \Iterator, \Countable {
	
	/**
	 * Main jump marks. 
	 * @var array<\wcf\system\Directory\EntryMainNode>
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
	 * @param	string		$anchor
	 * @param	string		$title
	 * @param	boolean		$isMainEntry
	 */
	public function addEntry($anchor, $title, $isMainEntry = true) {
		$entry = new Entry($anchor, $title);
		
		// sub jump mark is given and no main jumpmark exists.
		if ($isMainEntry == false && empty($this->entries)) {
			$this->entries[$this->counter] = new EntryMainNode(); // create a dummy jump mark.
			$this->entries[$this->counter]->setSubEntry($entry);
			$this->currentCounter = $this->counter;
			$this->counter++;
		}
		// sub jump mark is given and a main jump mark exists.
		else if ($isMainEntry == false) {
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