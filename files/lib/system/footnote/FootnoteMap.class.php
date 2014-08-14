<?php
namespace wcf\system\footnote;

// imports
use wcf\system\copyright\TeraliosBBCodesCopyright;
use wcf\system\exception\SystemException;
use wcf\system\SingletonFactory;
use wcf\system\WCF;

/**
 * List of all footnotes.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	GNU Lesser General Public License v3.0 <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package de.teralios.bbcodes
 */
class FootnoteMap extends SingletonFactory implements \Iterator, \Countable {
	/**
	 * Index counter for footnotes.
	 * @var	integer
	 */
	protected $index = 1;
	
	/**
	 * Index counter for array.
	 * @var	integer
	 */
	protected $indexArray = 0;
	
	/**
	 * Array with footnotes.
	 * @var	array<\wcf\system\footnote\Footnote>
	 */
	protected $footnotes = array();
	
	/**
	 * @see \wcf\system\SingletonFactory::init()
	 */
	protected function init() {
		WCF::getTPL()->assign('footnoteMap', $this);
	}
	
	/**
	 * Check footnote map for footnotes.
	 *
	 * @return boolean
	 */
	public function hasFootnotes() {
		TeraliosBBCodesCopyright::callCopyright();
		
		return ($this->count()) ? true : false;
	}
	
	/**
	 * Add a footnotenote.
	 *
	 * @param string $text
	 * @param integer $contentType
	 * @return integer
	 */
	public function add($text = '', $contentType = Footnote::TYPE_NO_HTML) {	
		if (isset($this->footnotes[$this->indexArray])) {
			++$this->index;
			++$this->indexArray;
		}
		
		$this->footnotes[] = new Footnote($this->index, $text, $contentType);
		return $this->index;
	}
	
	/**
	 * Return a foot note.
	 *
	 * @param	integer		$index
	 * @throws SystemException
	 * @return \wcf\system\footnote\Footnote
	 */
	public function getFootnote($index) {
		$index -= 1;
		if (!isset($this->footnotes[$index])) {
			return false;
			// throw new SystemException("No footnote found with index '".$index."'.");
		}
		else {
			return $this->footnotes[$index];
		}
	}
	
	/**
	 * @see Iterator::current()
	 */
	public function current() {
		return $this->footnotes[$this->indexArray];
	}

	/**
	 * @see Iterator::next()
	 */
	public function next() {
		++$this->indexArray;
	}

	/**
	 * @see Iterator::key()
	 */
	public function key() {
		return $this->indexArray;
	}

	/**
	 * @see Iterator::valid()
	 */
	public function valid() {
		return isset($this->footnotes[$this->indexArray]);
	}

	/**
	 * @see Iterator::rewind()
	 */
	public function rewind() {
		$this->indexArray = 0;
	}

	/**
	 * @see Countable::count()
	 */
	public function count() {
		return count($this->footnotes);	
	}
}