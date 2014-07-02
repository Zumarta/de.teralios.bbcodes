<?php
namespace wcf\system\bbcode;

// imports
use wcf\system\WCF;
use wcf\system\style\StyleHandler;

/**
 * Parste the [xattach] BBCode.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	GNU Lesser General Public License v3.0 <http://www.gnu.org/licenses/lgpl-3.0.txt>
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
			// new size
			if (ATTACHMENT_THUMBNAIL_WIDTH != 280) {
				$width = ATTACHMENT_THUMBNAIL_WIDTH + (str_replace('px', '', StyleHandler::getInstance()->getStyle()->getVariable('wcfGapTiny')) * 2);
				WCF::getTPL()->assign('xAttachSize', $width);
			}
			
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