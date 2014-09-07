<?php
namespace wcf\system\bbcode;

// imports
use wcf\util\StringUtil;

/**
 * Parse [dlist] BBCode to a definition list.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	GNU Lesser General Public License v3.0 <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package de.teralios.bbcodes
 */
class DefinitionListBBCode extends AbstractBBCode {
	/**
	 * @see \wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, \wcf\system\bbcode\BBCodeParser $parser) {
		$content = StringUtil::trim($text);
		if (!empty($content) || (mb_strpos($content, '[*]') !== false && mb_strpos($content, '[:]') !== false)) {
			// build main list elements
			$listElements = preg_split('#\[\*\]#', $content, -1, PREG_SPLIT_NO_EMPTY);
			foreach ($listElements AS $key => $val) {
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
				foreach ($listElements AS $point) {
					if (mb_substr_count($content, '[:]') == 1) {
						// reset key and value.
						$key = $value = '';
						
						// split list element on [:] in key and definition of key.
						list($key, $value) = preg_split('#\[:\]#', $content, -1);
						$key = StringUtil::trim($key);
						$value = StringUtil::trim($value);
						
						// key is not empty.
						if (!empty($key)) {
							if ($parser->getOutputType() == 'text/html') {
								$listContent .= '<dt>'.$key.'</dt><dd>'.$value.'</dd>';
							}
							elseif ($parser->getOutputType() == 'text/simplified-html') {
								$listContent .= $key.': '.$value."\n";
							}
						}
					}
				}
				
				if (!empty($listContent)) {
					if ($parser->getOutputType() == 'text/html') {
						return '<dl class="dlistBBCode">'.$listContent.'</dl>';
					}
					elseif ($parser->getOutputType() == 'text/simplified-html') {
						return $listContent;
					}
				}
			}
		}
		
		return '[dlist]'.$content.'[/dlist]';
	}
}