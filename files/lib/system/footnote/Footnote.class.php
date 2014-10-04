<?php
namespace wcf\system\footnote;

// imports
use wcf\util\StringUtil;
use wcf\system\bbcode\MessageParser;

/**
 * Represent a footnote.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class Footnote {
	/**
	 * Text of footnote.
	 * @var	string
	 */
	public $text = '';
	
	/**
	 * Index of footnote.
	 * @var	integer
	 */
	public $index = 0;
	
	/**
	 * Type of text.
	 * @var	integer
	 */
	protected $type = 0;
	
	/**
	 * HTML is allowed for text.
	 * @var	integer
	 */
	const TYPE_HTML = 1;
	
	/**
	 * HTML is disallowed for text.
	 * @var	integer
	 */
	const TYPE_NO_HTML = 2;
	
	/**
	 * Text contains BBCode.
	 * @var	integer
	 */
	const TYPE_BBCODE = 3;
	
	/**
	 * Creates footnote.
	 *
	 * @param	integer		$index
	 * @param	string		$text
	 * @param	integer		$type
	 */
	public function __construct($index, $text, $type = self::TYPE_NO_HTML) {
		$this->index = $index;
		$this->text = $text;
		$this->type = $type;
	}
	
	/**
	 * Set text for footnote.
	 *
	 * @param	string	$text
	 * @param	integer	$type
	 */
	public function setText($text, $type = self::TYPE_NO_HTML) {
		$this->type = $type;
		$this->text = $text;
	}
	
	/**
	 * Return id for html attribute id.
	 *
	 * @return string
	 */
	public function getTagID() {
		return static::getTagIndex($this->index);
	}
	
	/**
	 * Return index.
	 *
	 * @return	integer
	 */
	public function getIndex() {
		return $this->index;
	}
	
	/**
	 * Return text.
	 *
	 * @return string
	 */
	public function getText() {
		if ($this->type == self::TYPE_HTML) {
			return $this->text;
		}
		else if ($this->type == self::TYPE_BBCODE) {
			return MessageParser::getInstance()->parse($this->text);
		}
		else {
			return StringUtil::encodeHTML($this->text);
		}
	}
	
	/**
	 * Build content for html id attribute.
	 *
	 * @param unknown $index
	 * @return string
	 */
	public static function getTagIndex($index) {
		return 'footnote'.$index;
	}
}