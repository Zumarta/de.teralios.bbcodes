<?php
// namespace
namespace wcf\system\copyright;

// imports
use wcf\util\TeraliosUtil;

/**
 * Teralios BBCode Copyright class.
 *
 * @author	Karsten (Teralios) Achterrath
 * @copyright	2014 Teralios.de
 * @license	Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) <http://creativecommons.org/licenses/by-sa/4.0/legalcode>
 * @package de.teralios.bbcodes
 */
final class TeraliosBBCodesCopyright extends AbstractCopyright {
	protected $languageVariable = 'wcf.teralios.copyright.bbcodes';
	protected $key = '1b0d911514cc24c30a65918a6d6573d45e6da006';
	
	protected function init() {
		parent::init();
		
		// call easter egg. ;)
		TeraliosUtil::easterEgg(16);
	}
}