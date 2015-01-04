<?php
// namespace
namespace wcf\system\bbcode;

// imports
use wcf\system\copyright\TeraliosBBCodesCopyright;
use wcf\system\message\embedded\object\MessageEmbeddedObjectManager;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;
use wcf\util\StringUtil;

class XAttachBBCode extends AttachmentBBCode {
	protected static $icons = array(
		'default' => 'fa-file-o',
		'image' => 'fa-file-image-o',
		'zip' => 'fa-file-archive-o',
		'word' => 'fa-file-word-o',
		'pdf' => 'fa-file-pdf-o',
		'video' => 'fa-file-video-o',
		'audio' => 'fa-file-audio-o'
	);
	
	/**
	 * @see \wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, \wcf\system\bbcode\BBCodeParser $parser) {
		// call copyright
		TeraliosBBCodesCopyright::callCopyright();
		
		// default values
		$attachmentID = 0;
		$float = 'none';
		$title = WCF::getLanguage()->get('wcf.bbcode.xattach.title');
		$type = 'default';
		$link = '';
		$text = '';
		$isImage = false;
		
		// parameter values
		$attachmentID = (isset($openingTag['attributes'][0])) ? intval($openingTag['attributes'][0]) : 0;
		$float = (isset($openingTag['attributes'][1])) ? mb_strtolower($openingTag['attributes'][1]) : 'none';
		switch ($float) {
			case 'left':
			case 'right':
			case 'none':
				break;
			default:
				$float = 'none';
		}
		$text = StringUtil::trim($content);
		
		// get attachment
		$attachment = MessageEmbeddedObjectManager::getInstance()->getObject('de.teralios.bbcodes.attachment', $attachmentID);
		if ($attachment === null) {
			if (static::$attachmentList !== null) {
				$attachments = static::$attachmentList->getGroupedObjects(static::$objectID);
				if (isset($attachments[$attachmentID])) {
					$attachment = $attachments[$attachmentID];
					$attachment->markAsEmbedded();
				}
			}
		}
		
		// Attachment
		if ($attachment !== null) {
			$title = StringUtil::encodeHTML($attachment->filename);
			$linkParameters = array(
				'object' => $attachment
			);
			
			// can view image
			if ($attachment->showAsImage() && $attachment->canViewPreview()) {
				if ($attachment->hasThumbnail()) $linkParameters['thumbnail'] = 1;
				$isImage = true;
					
				$link = '<img src="'.StringUtil::encodeHTML(LinkHandler::getInstance()->getLink('Attachment', $linkParameters)).'"'.(!$attachment->hasThumbnail() ? ' class="embeddedAttachmentLink jsResizeImage"' : '').' style="width: '.($attachment->hasThumbnail() ? $attachment->thumbnailWidth : $attachment->width).'px; height: '.($attachment->hasThumbnail() ? $attachment->thumbnailHeight: $attachment->height).'px" alt="" />';
				if ($attachment->hasThumbnail() && $attachment->canDownload()) {
					$link = '<a href="'.StringUtil::encodeHTML(LinkHandler::getInstance()->getLink('Attachment', array('object' => $attachment))).'" title="'.$title.'" class="embeddedAttachmentLink jsImageViewer">'.$link.'</a>';
				}
			}
			// is image, but can not view image.
			else if ($attachment->showAsImage()) {
				$link = StringUtil::encodeHTML(LinkHandler::getInstance()->getLink('Attachment', array($linkParameters)));
				$type = 'image';
			}
			// is file
			else {
				$link = StringUtil::encodeHTML(LinkHandler::getInstance()->getLink('Attachment', array($linkParameters)));
				$type = self::getType($attachment);
			}
		}
		// fallback
		else {
			$link = StringUtil::encodeHTML(LinkHandler::getInstance()->getLink('Attachment', array('id' => $attachmentID)));
		}
		
		if ($parser->getOutputType() == 'text/html') {
			WCF::getTPL()->assign(array(
				'xaLink' => $link,
				'xaTitle' => $title,
				'xaIcon' => self::choseIcon($type),
				'xaIsImage' => $isImage,
				'xaText' => $text,
				'xaFloat' => $float,
			));
			$result = WCF::getTPL()->fetch('xAttachBBCode');
		}
		else {
			$result = StringUtil::getAnchorTag($link, $title).' ('.$text.')';
		}
		
		return $result;
	}
	
	protected static function getType(\wcf\data\attachment\Attachment $attachment = null) {
		return 'default';
	}
	
	protected static function choseIcon($type) {
		if (isset(static::$icons[$type])) {
			return static::$icons[$type];
		}
		else {
			return static::$icons['default'];
		}
	}
}