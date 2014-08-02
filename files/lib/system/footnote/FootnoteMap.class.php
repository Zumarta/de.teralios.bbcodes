<?php
namespace wcf\system\footnote;

// imports
use wcf\system\copyright\TeraliosBBCodesCopyright;
use wcf\system\exception\SystemException;
use wcf\system\SingletonFactory;
use wcf\system\WCF;

class FootnoteMap extends SingletonFactory implements \Iterator, \Countable {
	protected $index = 1;
	protected $indexArray = 0;
	protected $footnotes = array();
	
	protected function init() {
		WCF::getTPL()->assign('footnoteMap', $this);
	}
	
	public function hasFootnotes() {
		TeraliosBBCodesCopyright::callCopyright();
		
		return ($this->count()) ? true : false;
	}
	
	public function add($text = '', $allowHTML = true) {		
		if (isset($this->footnotes[$this->indexArray])) {
			++$this->index;
			++$this->indexArray;
		}
		
		$this->footnotes[] = new Footnote($this->index, $text, (($allowHTML) ? Footnote::TYPE_HTML : Footnote::TYPE_NO_HTML));
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
		if (!isset($this->footnotes[$index])) {
			throw new SystemException("No footnote found with index '".$index."'.");
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