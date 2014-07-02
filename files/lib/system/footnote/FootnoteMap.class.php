<?php
namespace wcf\system\footnote;

// imports
use wcf\system\SingletonFactory;

class FootnoteMap extends SingletonFactory implements \Iterator, \Countable {
	protected $index = 1;
	protected $indexArray = 1;
	protected $footnotes = array();
	
	public function add($text, $allowHTML = true) {		
		if (isset($this->footnotes[$this->index])) {
			++$this->index;
		}
		
		$this->footnotes[$this->index] = new Footnote($this->index, $text, (($allowHTML) ? Footnote::TYPE_HTML : Footnote::TYPE_NO_HTML));
		return $this->index;
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
		$this->index = 1;
	}

	/**
	 * @see Countable::count()
	 */
	public function count() {
		return count($this->footnotes);	
	}
}