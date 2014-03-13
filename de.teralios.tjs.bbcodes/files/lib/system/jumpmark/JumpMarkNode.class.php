<?php
// namespace
namespace wcf\system\jumpmark;

/**
 * Jump mark node for jump mark map.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	GNU General Public License <http://opensource.org/licenses/gpl-license.php>
 * @package
 */
class JumpMarkNode {
	
	/**
	 * Jump mark object.
	 * 
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