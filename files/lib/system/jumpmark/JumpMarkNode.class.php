<?php
namespace wcf\system\jumpmark;

/**
 * Jump mark node for jump mark map.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	GNU Lesser General Public License v3.0 <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package
 */
class JumpMarkNode {
	/**
	 * Jump mark object.
	 * @var \wcf\system\jumpmark\JumpMark
	 */
	protected $jumpMark = null;
	
	/**
	 * Create jump mark node.
	 * 
	 * @param \wcf\system\jumpmark\JumpMark $jumpMark
	 */
	public function __construct(\wcf\system\jumpmark\JumpMark $jumpMark = null) {
		$this->jumpMark = $jumpMark;
	}
	
	/**
	 * Return jump mark object.
	 * 
	 * @return \wcf\system\jumpmark\JumpMark
	 */
	public function getJumpMark() {
		return $this->jumpMark;
	}
	
	/**
	 * Return true if a jump mark exists in node.
	 * 
	 * @return boolean
	 */
	public function existJumpMark() {
		return ($this->jumpMark === null) ? false : true;
	}
}