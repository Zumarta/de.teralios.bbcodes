<?php
// namespace
namespace wcf\system\bbcode;

// imports
use wcf\system\copyright\TeraliosBBCodesCopyright;
use wcf\system\message\embedded\object\MessageEmbeddedObjectManager;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Parse xattach tag.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class XAttachBBCode extends AttachmentBBCode {
	/**
	 * Icons for a file type.
	 * @var array<text>
	 */
	protected static $icons = array(
		'default' => 'fa-file-o',
		'image' => 'fa-file-image-o',
		'archiv' => 'fa-file-archive-o',
		'word' => 'fa-file-word-o',
		'pdf' => 'fa-file-pdf-o',
		'text' => 'fa-file-text-o',
		'excel' => 'fa-file-excel-o',
		'video' => 'fa-file-video-o',
		'audio' => 'fa-file-audio-o',
		'code' => 'fa-file-code-o'
	);
	
	/**
	 * Supportet files for a special icon.
	 * @var array<text>
	 */
	protected static $fileTypes = array(
		'pdf' => 'pdf',
		'doc' => 'word',
		'docx' => 'word',
		'xls' => 'excel',
		'xlsx' => 'excel',
		'txt' => 'text',
		'odt' => 'text',
		'rtf' => 'text',
		'zip' => 'archiv',
		'rar' => 'archiv',
		'gz' => 'archiv',
		'tar' => 'archiv',
		'tgz' => 'archiv',
		'acc' => 'audio',
		'mp3' => 'audio',
		'mp4' => 'video',
		'avi' => 'video'
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
				$link = StringUtil::encodeHTML(LinkHandler::getInstance()->getLink('Attachment', array('object' => $attachment)));
				$type = 'image';
			}
			// is file
			else {
				$link = StringUtil::encodeHTML(LinkHandler::getInstance()->getLink('Attachment', array('object' => $attachment)));
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
				'xaNoBorder' => BBCODES_XATTACH_FREESTYLE
			));
			$result = WCF::getTPL()->fetch('xAttachBBCode');
		}
		else {
			$result = StringUtil::getAnchorTag($link, $title).' ('.$text.')';
		}
		
		return $result;
	}
	
	/**
	 * Return type of a file.
	 *
	 * @param	\wcf\data\attachment\Attachment $attachment
	 * @return	string
	 */
	protected static function getType(\wcf\data\attachment\Attachment $attachment = null) {
		if ($attachment !== null) {
			$filename = $attachment->filename;
			$dotPosition = strrpos($filename, '.') + 1;
			$end = mb_strtolower(substr($filename, $dotPosition));
			if (isset(self::$fileTypes[$end])) {
				return self::$fileTypes[$end];
			}
			else {
				return 'default';
			}
		}
		else {
			return 'default';
		}
	}
	
	/**
	 * Return icon for a type.
	 *
	 * @param	string		$type
	 * @return	text
	 */
	protected static function choseIcon($type) {
		if (isset(static::$icons[$type])) {
			return static::$icons[$type];
		}
		else {
			return static::$icons['default'];
		}
	}
}