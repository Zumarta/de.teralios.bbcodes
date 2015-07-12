<?php
namespace wcf\system\bbcode;

// imports
use wcf\system\copyright\TeraliosBBCodesCopyright;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Parse [dlist] BBCode to a definition list.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014-2015 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class DefinitionListBBCode extends AbstractBBCode {
	/**
	 * @see \wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		// copyright
		TeraliosBBCodesCopyright::callCopyright();
		
		$content = StringUtil::trim($content);
		if (!empty($content) || (mb_strpos($content, '[.]') !== false && mb_strpos($content, '[:]') !== false)) {
			$content = str_replace('[.]', '[*]', $content);
			// build main list elements
			$listElements = preg_split('#\[\*\]#', $content, -1, PREG_SPLIT_NO_EMPTY);
			foreach ($listElements as $key => $val) {
				$val = StringUtil::trim($val);
				if (empty($val) || $val == '<br />') {
					unset($listElements[$key]);
				}
				else {
					$listElements[$key] = $val;
				}
			}
			
			// build list
			if (!empty($listElements)) {
				$listContent = '';
				foreach ($listElements as $point) {
					if (mb_substr_count($point, '[:]') == 1) {
						// reset key and value.
						$key = $value = '';
						
						// split list element on [:] in key and definition of key.
						list($key, $value) = preg_split('#\[:\]#', $point, -1);
						$key = StringUtil::trim($key);
						$value = StringUtil::trim($value);
						if (empty($value)) $value = WCF::getLanguage()->get('wcf.bbcode.dlist.noDefinition');
						
						// key is not empty.
						if (!empty($key)) {
							if ($parser->getOutputType() == 'text/html') {
								$listContent .= '<dt>'.$key.'</dt><dd>'.$value.'</dd>';
							}
							elseif ($parser->getOutputType() == 'text/simplified-html') {
								 $listContent .= '*'.$key.': '.$value."\n";
							}
						}
					}
				}
				
				if (!empty($listContent)) {
					if ($parser->getOutputType() == 'text/html') {
						return '<dl class="dlistBBCode">'.$listContent.'</dl>';
					}
					else if ($parser->getOutputType() == 'text/simplified-html') {
						return $listContent;
					}
				}
			}
		}
		
		return '[dlist]'.$content.'[/dlist]';
	}
}
