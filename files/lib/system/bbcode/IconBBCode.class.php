<?php
// namespace
namespace wcf\system\bbcode;

// imports
use wcf\system\copyright\TeraliosBBCodesCopyright;
use wcf\util\ArrayUtil;
use wcf\util\StringUtil;

/**
 * Icon bbcode.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014-2015 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class IconBBCode extends AbstractBBCode {
	protected $float = 'none';
	protected $size = 16;
	
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		// copyright
		TeraliosBBCodesCopyright::callCopyright();
		
		// first attribut is icon!
		$icon = (isset($openingTag['attributes'][0])) ? StringUtil::trim($openingTag['attributes'][0]) : 'fa-rebel'; // Yes, Rebel icon as default icon! ;)
		if (substr($icon, 0, 3) != 'fa-') {
			$icon = 'fa-'.$icon;
		}
		
		// map attributes
		$this->mapAttributes(ArrayUtil::trim($openingTag['attributes']));
		
		return '<span class="icon'.(($this->size > 0) ? ' icon'.$this->size : '').' '.$icon.(($this->float != 'none') ? ' iconBB'.ucfirst($this->float) : '').' iconBBCode"></span>';
	}
	
	/**
	 * Maps attributes
	 * 
	 * @param array $attributes
	 */
	protected function mapAttributes($attributes) {
		$this->size = 16;
		$this->float = 'none';
		
		if (isset($attributes[1])) {
			if (preg_match('#^(left|right|none)$#i', $attributes[1])) {
				$this->float = mb_strtolower($attributes[1]);
				
				if (isset($attributes[2]) && preg_match('#^(0|16|24|32|48|96)$#', $attributes[2])) {
					$this->size = $attributes[2];
				}
			}
			else {
				if (preg_match('#^(0|16|24|32|48|96)$#', $attributes[1])) {
					$this->size = $attributes[1];
				}
				
				if (isset($attributes[2]) && preg_match('#^(left|right|none)$#i', $attributes[2])) {
					$this->float = mb_strtolower($attributes[2]);
				}
			}
		}
	}
}
