<?php
// namespace
namespace wcf\system\message\embedded\object;

// imports
use wcf\data\attachment\AttachmentList;
use wcf\util\ArrayUtil;

/**
 * Added attachment to embedded object manager.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
class XAttachmentMessageEmbeddedObjectHandler extends AttachmentMessageEmbeddedObjectHandler {
	static protected $attachmentIDs = array();

	/**
	 * @see \wcf\system\message\embedded\object\IMessageEmbeddedObjectHandler::parseMessage()
	 */
	public function parseMessage($message) {
		// yes i know... but what i can do diffrent to the parent class? ;) I am only need xattach... Stupid!
		$return = false;
		$parsedIDs = array_unique(ArrayUtil::toIntegerArray(self::getFirstParameters($message, 'xattach')));
		
		if (!empty($parsedIDs)) {
			$attachmentIDs = array();
			foreach ($parsedIDs as $attachmentID) {
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
	
	/**
	 * @see \wcf\system\message\embedded\object\AttachmentMessageEmbeddedObjectHandler::loadObjects()
	 */
	public function loadObjects(array $objectIDs) {
		$objects = parent::loadObjects($objectIDs);
		
		// set ids and object ids to mark attachments as embedded...
		foreach ($objects as $object) {
			self::$attachmentIDs[$object->objectID][] = $object->attachmentID;
		}

		return $objects;
	}
	
	/**
	 * Return IDs.
	 *
	 * @return multitype:
	 */
	public static function getAttachmentIDs() {
		return self::$attachmentIDs;
	}
}
