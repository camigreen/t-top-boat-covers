<?php
// namespace administrator\components\com_jmap\framework\html;
/**  
 * @package JMAP::administrator::components::com_jmap
 * @subpackage framework
 * @subpackage html
 * @author Joomla! Extensions Store
 * @copyright (C) 2014 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport('joomla.language.helper');

/**
 * Languages available
 *
 * @package JMAP::administrator::components::com_jmap
 * @subpackage framework
 * @subpackage html
 *        
 */
class JMapHtmlLanguages extends JObject {
	/**
	 * Build the multiple select list for Menu Links/Pages
	 * 
	 * @access public
	 * @return array
	 */
	public static function getAvailableLanguageOptions() {
		$knownLangs = JLanguageHelper::getLanguages();
		 
		// Get default site language
		$langParams = JComponentHelper::getParams('com_languages');
		// Setup predefined site language
		$defaultLanguage = @array_shift(explode('-', strtolower($langParams->get('site'))));
		
		$langs[] = JHTML::_('select.option',  $defaultLanguage, '- '. JText::_('COM_JMAP_DEFAULT_SITE_LANG' ) .' -' );
		
		// Create found languages options
		foreach ($knownLangs as $langObject) {
			// Extract tag lang
			$langs[] = JHTML::_('select.option',  $langObject->sef, $langObject->title );
		}
		 
		return $langs;
	}
}