<?php
// namespace
namespace wcf\system\bbcode;

// imports
use wcf\system\WCF;

/**
 * Parste the [xattach] BBCode.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	GNU General Public License <http://opensource.org/licenses/gpl-license.php>
 * @package de.teralios.tjs.bbcodes
 */
class XAttachBBCode extends AttachmentBBCode {
	
	/**
	 * @see	\wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		// xattach params.
		$attachmentID = 0;
		if (isset($openingTag['attributes'][0])) {
			$attachmentID = $openingTag['attributes'][0];
		}
		$float = (isset($openingTag['attributes'][1])) ? $openingTag['attributes'][1] : '';
		$openingTag['attributes'][1] = '';
		$description = $content;
		
		// get attachment link from attachment bbcode.
		$attachmentLink = parent::getParsedTag($openingTag, '', $closingTag, $parser);

		if ($parser->getOutputType() == 'text/html') {
			WCF::getTPL()->assign(array(
				'attachmentLink' => $attachmentLink,
				'float' => $float,
				'description' => $description,
			));
			$xAttach = WCF::getTPL()->fetch('xAttachBBCodeTag');
		}
		else {
			// simple description.
			$xAttach = $attachmentLink.' ('.$description.')';
		}
		
		return $xAttach;
	}
}