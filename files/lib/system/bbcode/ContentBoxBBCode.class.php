<?php
namespace wcf\system\bbcode;

// imports
use wcf\system\copyright\TeraliosBBCodesCopyright;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Parse box bbcode.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014-2015 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class ContentBoxBBCode extends AbstractBBCode {
	protected $title = '';
	protected $position = '';
	protected $size = 0;
	/**
	 * @see \wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag,\wcf\system\bbcode\BBCodeParser $parser) {
		//copyright
		TeraliosBBCodesCopyright::callCopyright();
		
		// map attributes
		$this->mapAttributes($openingTag['attributes']);
		
		// assign vattributes
		$title = $this->title;
		$position = $this->position;
		$size = $this->size;
		
		// size settings.
		if ($size == 0 && ($position == 'left' || $position == 'right')) {
			$size = 2;
		}
		else if ($size == 0) {
			$size = 4;
		}
		
		// parse box with out HTML
		if ($parser->getOutputType() == 'text/simplified-html') {
			if (!empty($title)) {
				$return = '<br />----( '.$title.' )----<br />';
			}
			else {
				$return = '<br />--------<br />';
			}
			$return .= $content;
			$return .= '<br />--------<br />';
			return $return;
		}
		// parse box with HTML
		else if ($parser->getOutputType() == 'text/html') {
			WCF::getTPL()->assign(array(
				'boxTitle' => $title,
				'boxPosition' => $position,
				'boxSize' => $size,
				'boxContent' => $content
			));
			
			return WCF::getTPL()->fetch('contentBoxBBCode', 'wcf');
		}
	}
	
	protected function mapAttributes($attributes) {
		// reset attributes
		$this->title = $this->position = '';
		$this->size = 0;
		
		// map attributes
		$this->title = (isset($attributes[0])) ? StringUtil::trim($attributes[0]) : '';
		$this->position = (isset($attributes[1])) ? mb_strtolower($attributes[1]) : 'none';
		$this->size = (isset($attributes[2])) ? $attributes[2] : 0;
	}
}