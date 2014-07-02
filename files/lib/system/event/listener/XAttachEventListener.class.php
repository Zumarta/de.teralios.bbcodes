<?php
namespace wcf\system\event\listener;

// imports
use wcf\data\package\Package;
use wcf\system\event\IEventListener;
use wcf\system\wcf;
use wcf\util\ArrayUtil;

/**
 * Check wcf version for experimantal wcf2.1 support.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	GNU Lesser General Public License v3.0 <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package de.teralios.bbcodes
 */
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