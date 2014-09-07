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
			$listContent = preg_split('#\[\*\]#', $content, -1, PREG_SPLIT_NO_EMPTY);
			foreach ($listContent AS $key => $value) {
				$value = StringUtil::trim($value);
				if (empty($value) || $value == '<br />') {
					unset($listContent[$key]);
				}
				else {
					$listContent[$key] = $value;
				}
			}
			
			if (!empty($listContent)) {
				
			
			}
		}
		else {
			$return = '[dlist]'.$content.'[/dlist]';
		}
		
		return $return;
	}
}