<?php
// namespace
namespace wcf\system\bbcode;

// imports
use wcf\system\WCF;

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
	}
}