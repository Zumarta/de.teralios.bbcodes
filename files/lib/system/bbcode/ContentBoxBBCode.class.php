<?php
namespace wcf\system\bbcode;

// imports
use wcf\system\bbcode\BBCodeParser;
use wcf\system\copyright\TeraliosBBCodesCopyright;
use wcf\system\WCF;
use wcf\util\ArrayUtil;

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
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		//copyright
		TeraliosBBCodesCopyright::callCopyright();
		
		// map attributes
		$this->mapAttributes($openingTag);
		
		// assign vattributes
		$title = $this->title;
		$position = $this->position;
		$size = $this->size;
		
		// size settings.
		if ($size == 0 && ($position == 'left' || $position == 'right')) {
			$size = 2;
		}
		else {
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
	
	/**
	 * Maps bbcode attributes to html/template attributes.
	 * 
	 * @param	array	$openingTag
	 */
	protected function mapAttributes($openingTag) {
		// reset attributes
		$this->title = $this->position = '';
		$this->size = 0;
		
		if (isset($openingTag['attributes'])) {
			$attributes = ArrayUtil::trim($openingTag['attributes']);
			
			// first ist position
			if (preg_match('#^(left|right)$#i', $attributes[0])) {
				$this->position = $attributes[0];
				
				// Attribute 2 and 3
				if (isset($attributes[1])) {
					// attribute is size
					if (preg_match('#^(1|2|3|4)$#', $attributes[1])) {
						$this->size = $attributes[1];
						
						// third is title.
						if (isset($attributes[2])) {
							$this->title = $attributes[2];
						}
					}
					// attribbut is title
					else {
						$this->title = $attributes[1];
						
						// attribute 3 must be size.
						if (isset($attributes[2]) && preg_match('#^(1|2|3|4)$#', $attributes[2])) {
							$this->size = $attributes[2];
						}
					}
				}
			}
			// first is size
			else if (preg_match('#^(1|2|3|4)$#', $attributes[0])) {
				$this->size = $attributes[0];
				
				// Attribute 2 and 3
				if (isset($attributes[1])) {
					// attribute is position
					if (preg_match('#^(left|right)$#si', $attributes[1])) {
						$this->position = $attributes[1];
				
						// third is title.
						if (isset($attributes[2])) {
							$this->title = $attributes[2];
						}
					}
					else {
						// second is title
						$this->title = $attributes[1];
				
						// third must be size.
						if (isset($attributes[2]) && preg_match('#^(left|right)$#i', $attributes[2])) {
							$this->position = $attributes[2];
						}
					}
				}
			}
			// first is title
			else {
				$this->title = $attributes[0];
				
				// Attribute 2 and 3
				if (isset($attributes[1])) {
					// second is position
					if (preg_match('#^(left|right)$#si', $attributes[1])) {
						$this->position = $attributes[1];
				
						// third must be size.
						if (isset($attributes[2]) && preg_match('#^(1|2|3|4)$#', $attributes[2])) {
							$this->size = $attributes[2];
						}
					}
					// second is size.
					else if (preg_match('#^(1|2|3|4)$#', $attributes[1])) {
						$this->size = $attributes[1];
				
						// third must be position
						if (isset($attributes[2]) && preg_match('#^(left|right)$#i', $attributes[2])) {
							$this->position = $attributes[2];
						}
					}
				}
			}
		}
		
		// position check
		if (!empty($this->position)) $this->position = mb_strtolower($this->position);
	}
}