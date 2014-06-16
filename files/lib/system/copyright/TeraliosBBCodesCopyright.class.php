<?php
namespace wcf\system\copyright;

/**
 * BBCode copyright.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	GNU Lesser General Public License v3.0 <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.teralios.tjs.bbcodes
 */
final class TeraliosBBCodes extends AbstractCopyright {
	protected static $countedCopyright = true;
	protected static $countMax = 3;
	protected static $langVar = 'wcf.teralios.copyright.bbcodes';
	protected static $key = '1b0d911514cc24c30a65918a6d6573d45e6da006';
}