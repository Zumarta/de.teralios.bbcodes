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
	public function getParsedTag(array $openingTag, $content, array $closingTag,\wcf\system\bbcode\BBCodeParser $parser) {
		
		// build hash from content and check footnotes for existing hash. When exists, use old index and co.
		$hash = StringUtil::getHash($content);
		if (!isset(static::$footnotes[$hash])) {
			$footnoteIndex = FootnoteMap::getInstance()->add($content, true);
			static::$footnotes[$hash] = $footnoteIndex;
		}
		else {
			$footnoteIndex = static::$footnotes[$hash];
		}
		
		// get a short preview for title tag.
		$tooltipContent = StringUtil::truncate(StringUtil::stripHTML($content), 100);
		$footnoteTagIndex = Footnote::getTagIndex($footnoteIndex);
		
		WCF::getTPL()->assign(array(
			'footnoteTagID' => $footnoteTagIndex,
			'footnoteIndex' => $footnoteIndex,
			'footnoteTooltip' => $tooltipContent
		));
		
		return WCF::getTPL()->fetch('footnoteBBCode');
	}
}