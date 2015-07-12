<?php
namespace wcf\system\bbcode;

// imports
use wcf\system\copyright\TeraliosBBCodesCopyright;
use wcf\system\WCF;
use wcf\util\ArrayUtil;
use wcf\util\StringUtil;
use wcf\util\TeraliosUtil;

/**
 * Pro and Contra BBCode for the wcf2.0.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014-2015 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class ProContraBBCode extends AbstractBBCode {
	const SPLIT_PATTERN = '#\[([+-\\\*])\]#';
	
	protected $title = '';
	protected $position = 'none';

	/**
	 * @see	\wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		// copyright counter.
		TeraliosBBCodesCopyright::callCopyright();
		TeraliosUtil::easterEgg(16);
		
		// map attributes
		$this->mapAttributes($openingTag);
		
		// assign values
		$title = $this->title;
		$position = $this->position;
		$points = array();
		
		// build array
		$content = str_replace('[.]', '[*]', $content);
		if (preg_match(self::SPLIT_PATTERN, $content)) {
			// split on [+] [-] or [*]
			$elements = array();
			$elements = preg_split(self::SPLIT_PATTERN, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
			
			// remove first element.
			unset($elements[0]);
			
			// build array for points.
			if (!empty($elements)) {
				$i = 1;
				$count = count($elements);
				while ($i < $count) {
					$sign = $elements[$i];
					$value = StringUtil::trim($elements[($i + 1)]);
					
					// check value, when is not empty, add.
					if (!empty($value) && $value != '<br />') {
						if (!isset($points[$sign])) {
							$points[$sign] = array();
						}
						$points[$sign][] = $value;
					}
					
					// current index + 2
					$i =  $i+2;
				}
			}
		}
		
		// output
		if (empty($points)) {
			return '[procontra]'.$content.'[/procontra]';
		}
		else if ($parser->getOutputType() == 'text/html') {
			
			// assign variables
			WCF::getTPL()->assign(array(
				'pcTitle' => $title,
				'pcPoints' => $points,
				'pcPosition' => $position
			));
			
			return	WCF::getTPL()->fetch('proContraBBCodeTag');
		}
		else if ($parser->getOutputType() == 'text/simplified-html') {
			// no supports simplified html.
			$return = $title.'<br />';
			$return .= str_repeat('-', mb_strlen($title)).'<br />';
			foreach ($points as $sign => $values) {
				$length = count($values);
				if ($length > 0) {
					$length--;
					for ($i = 0; $i <= $length; $i++) {
						$return .= $sign.' '.$values[$i].'<br />';
					}
				}
			}
			
			return $return;
		}
	}
	
	/**
	 * Maps bbcode attributes to html/template attributes.
	 * 
	 * @param	array	$openingTag
	 */
	protected function mapAttributes($openingTag) {
		// reset attributes
		$this->title = '';
		$this->position = 'none';
		
		if (isset($openingTag['attributes'])) {
			$attributes = ArrayUtil::trim($openingTag['attributes']);
			
			if (isset($attributes[0])) {
				if (preg_match('#^(left|right)$#i', $attributes[0])) {
					$this->position = mb_strtolower($attributes[0]);
					
					if (isset($attributes[1])) {
						$this->title = $attributes[1];
					}
				}
				else {
					$this->title = $attributes[0];
					
					if (isset($attributes[1]) && preg_match('#^(left|right)$#i')) {
						$this->position = mb_strtolower($attributes[1]);
					}
				}
			}
		}
		
		// map attributes
		if (empty($this->title)) {
			$this->title = WCF::getLanguage()->get('wcf.bbcode.proContra');
		}
	}
}
