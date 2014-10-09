<?php
namespace wcf\system\bbcode;

// imports
use wcf\system\WCF;

/**
 * Parste the [xattach] BBCode.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
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
		$float = (isset($openingTag['attributes'][1])) ? $openingTag['attributes'][1] : 'inline';
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
			return WCF::getTPL()->fetch('xAttachBBCodeTag');
		}
		else {
			// simple description.
			return $attachmentLink.' ('.$description.')';
		}
	}
}