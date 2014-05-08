<?php
// namespace
namespace wcf\system\jumpmark;

// imports
use wcf\system\SingletonFactory;
use wcf\system\WCF;
use wcf\util\JSON;

/**
 * Maps of jumpmarks given from heading/subheading bbcode.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	GNU Lesser General Public License v3.0 <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package
 */
class JumpMarkMap extends SingletonFactory implements \Iterator, \Countable {
	
	/**
	 * Main jump marks.
	 * 
	 * @var array<\wcf\system\jumpmarks\JumpMarkMainNode>
	 */
	protected $jumpMarks = array();
	
	/**
	 * Index for \Iterator.
	 * 
	 * @var	number
	 */
	protected $index = 0;
	
	/**
	 * Counter for setting jump marks.
	 * 
	 * @var	number
	 */
	protected $counter = 0;
	
	/**
	 * Current Counter for jump marks.
	 * 
	 * Use when a sub jump mark is given.
	 * 
	 * @var number
	 */
	protected $currentCounter = 0;
	
	/**
	 * Dev note is set.
	 * 
	 * @var	boolean
	 */
	protected $devNoteIsSet = false;
	
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
	public function addJumpMark($jumpMark, $title, $isSubMark = false) {
		$jumpMark = new JumpMark($jumpMark, $title);
		
		// sub jump mark is given and no main jumpmark exists.
		if ($isSubMark == true && empty($this->jumpMarks)) {
			$this->jumpMarks[$this->counter] = new JumpMarkMainNode(); // create a dummy jump mark.
			$this->jumpMarks[$this->counter]->setSubJumpMark($jumpMark);
			$this->currentCounter = $this->counter;
			$this->counter++;
		}
		// sub jump mark is given and a main jump mark exists.
		else if ($isSubMark == true) {
			$this->jumpMarks[$this->currentCounter]->setSubJumpMark($jumpMark);
		}
		// main jumpmark is given.
		else {
			$this->jumpMarks[$this->counter] = new JumpMarkMainNode($jumpMark);
			$this->currentCounter = $this->counter;
			$this->counter++;
		}
	}
	
	/**
	 * Return Jumpmarks as json string.
	 * @return string
	 */
	public function getJSON() {
		return JSON::encode($this->jumpMarks);
	}
	
	/**
	 * Return true if jump marks exists.
	 * 
	 * @return boolean
	 */
	public function hasJumpMarks() {
		// set dev note.
		if ($this->devNoteIsSet == false) {
			$this->devNoteIsSet = true;
			WCF::getTPL()->assign('directoryDevNote', true);
		}
		
		return ($this->count() > 0) ? true : false;
	}

	/**
	 * @see Iterator::current()
	 */
	public function current() {
		return $this->jumpMarks[$this->index];
	}
	
	/**
	 * @see Countable::count()
	 */
	public function count() {
		return count($this->jumpMarks);
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
		return isset($this->jumpMarks[$this->index]);
	}

	/**
	 * @see Iterator::rewind()
	 */
	public function rewind() {
		$this->index = 0;
	}
}