<?php
namespace wcf\system\event\listener;

use wcf\data\package\Package;
use wcf\system\event\IEventListener;
use wcf\system\wcf;
use wcf\util\ArrayUtil;


final class XAttachEventListener implements IEventListener {
	/**
	 * @see \wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		// x attach is allowed
		$xAttachAllowed = true;
		$allowedBBCodes = WCF::getSession()->getPermission($eventObj->allowedBBCodesPermission);
		$allowedBBCodes = ArrayUtil::trim(explode(',', $allowedBBCodes));
		if (!in_array('xattach', $allowedBBCodes)) {
			$xAttachAllowed = false;
		}
		
		$currentVersion = preg_replace('#\((\w)+\)#', '', WCF_VERSION);
		$isWCF21 = Package::compareVersion($currentVersion, '2.1.0 alpha 1', '>=');
		
		WCF::getTPL()->assign(array(
			'xAttachButton' => $xAttachAllowed,
			'isWCF21' => $isWCF21
		));
		
	}
}