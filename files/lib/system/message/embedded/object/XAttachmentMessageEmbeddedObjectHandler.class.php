<?php
// namespace
namespace wcf\system\message\embedded\object;

// imports
use wcf\data\attachment\AttachmentList;
use wcf\util\ArrayUtil;

class XAttachmentMessageEmbeddedObjectHandler extends AttachmentMessageEmbeddedObjectHandler {
	/**
	 * @see \wcf\system\message\embedded\object\IMessageEmbeddedObjectHandler::parseMessage()
	 */
	public function parseMessage($message) {
		// yes i know... but what i can do diffrent to the parent class? ;) I am only need xattach... Stupid!
		$return = false;
		$parsedIDs = array_unique(ArrayUtil::toIntegerArray(self::getFirstParameters($message, 'xattach')));
		
		if (!empty($parsedIDs)) {
			$attachmentIDs = array();
			foreach ($parsedIDs as  $attachmentID) {
				if ($attachmentID) {
					$attachmentIDs[] = $attachmentID;
				}
			}
			
			if (!empty($attachmentIDs)) {
				$attachmentList = new AttachmentList();
				$attachmentList->getConditionBuilder()->add("attachment.attachmentID IN (?)", array($attachmentIDs));
				$attachmentList->readObjectIDs();
	
				$return = $attachmentList->getObjectIDs();
			}
		}
	
		return $return;
	}
}