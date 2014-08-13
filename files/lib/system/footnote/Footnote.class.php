<?php
namespace wcf\system\footnote;

// imports
use wcf\util\StringUtil;
use wcf\system\bbcode\MessageParser;

class Footnote {
	public $text = '';
	public $index = 0;
	protected $type = 0;
	
	const TYPE_HTML = 1;
	const TYPE_NO_HTML = 2;
	const TYPE_BBCODE = 3;
	
	public function __construct($index, $text, $type = self::TYPE_NO_HTML) {
		$this->index = $index;
		$this->text = $text;
		$this->type = $type;
	}
	
	public function setText($text, $type = self::TYPE_NO_HTML) {
		$this->type = $type;
		$this->text = $text;
	}
	
	public function getTagID() {
		return static::getTagIndex($this->index);
	}
	
	public function getIndex() {
		return $this->index;
	}
	
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
	
	public static function getTagIndex($index) {
		return 'footnote'.$index;
	}
}