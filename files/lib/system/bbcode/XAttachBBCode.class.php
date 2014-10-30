<?php
namespace wcf\system\bbcode;

// imports
use wcf\system\message\embedded\object\MessageEmbeddedObjectManager;
use wcf\system\request\LinkHandler;
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
			$icon = false;
			$title = false;
			
			// check attachment for embedded image or other file types
			$attachment = MessageEmbeddedObjectManager::getInstance()->getObject('com.woltlab.wcf.attachment', $attachmentID);
			if (!$attachment->showAsImage() || !$attachment->canViewPreview()) {
				$attachmentLink = LinkHandler::getInstance()->getLink('Attachment', array('object' => $attachment));
				$title = $attachment->filename;
				$icon = ($attachment->isImage == true) ? 'fa-file-image-o' : 'fa-file-o';
			}
			
			
			WCF::getTPL()->assign(array(
				'xIcon' => $icon,
				'xTitle' => $icon,
				'xAttachmentLink' => $attachmentLink,
				'xFloat' => $float,
				'xDescription' => $description,
			));
			return WCF::getTPL()->fetch('xAttachBBCodeTag');
		}
		else {
			// simple description.
			return $attachmentLink.((!empty($description)) ? ' ('.$description.')' : '');
		}
	}
}