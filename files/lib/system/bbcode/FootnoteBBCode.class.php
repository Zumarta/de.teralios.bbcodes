<?php
namespace wcf\system\bbcode;

// imports
use wcf\system\footnote\Footnote;
use wcf\system\footnote\FootnoteMap;
use wcf\system\WCF;
use wcf\util\StringUtil;

class FootnoteBBCode extends AbstractBBCode {
	protected static $footnotes = array();
	
	/**
	 * @see \wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, \wcf\system\bbcode\BBCodeParser $parser) {
		// footnote and fn parse.
		if ($openingTag['name'] == 'fn' || $openingTag['name'] == 'footnote') {
			// no content and no index for content tag: drop footnote.
			$content = StringUtil::trim($content);
			if (empty($content) && !isset($openingTag['attributes'][0])) {
				return '';
			}
			
			// build hash from content or use index for content attribute
			$hash = (!empty($content)) ? StringUtil::getHash($content) : $openingTag['attributes'][0];
			
			// check footnotes for existing content or 
			if (!isset(static::$footnotes[$hash])) {
				$footnoteIndex = FootnoteMap::getInstance()->add($content, Footnote::TYPE_BBCODE);
				static::$footnotes[$hash] = $footnoteIndex;
			}
			else {
				$footnoteIndex = static::$footnotes[$hash];
			}
			
			// get a short preview from content (if is set)
			$tooltipContent = StringUtil::truncate(StringUtil::stripHTML($content), 100);
			$footnoteTagIndex = Footnote::getTagIndex($footnoteIndex);
			
			WCF::getTPL()->assign(array(
				'footnoteTagID' => $footnoteTagIndex,
				'footnoteIndex' => $footnoteIndex,
				'footnoteTooltip' => $tooltipContent
			));
			
			return WCF::getTPL()->fetch('footnoteBBCode');
		}
		// footnote content
		else {
			$contentIndex = $openingTag['attributes'][0];
			if (isset(static::$footnotes[$contentIndex])) {
				$index = static::$footnotes[$contentIndex];
				$footnote = FootnoteMap::getInstance()->getFootnote($index);
				if ($footnote != false) {
					$footnote->setText(StringUtil::trim($content), Footnote::TYPE_BBCODE);
				}
			}
			
			return '';
		}
	}
}