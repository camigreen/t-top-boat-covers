<?php
// namespace administrator\components\com_jmap\controllers;
/**
 *
 * @package JMAP::CPANEL::administrator::components::com_jmap
 * @subpackage controllers
 * @author Joomla! Extensions Store
 * @copyright (C) 2014 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 * CPanel controller
 *
 * @package JMAP::CPANEL::administrator::components::com_jmap
 * @subpackage controllers
 * @since 1.0
 */
class JMapControllerHelp extends JMapController {
	/**
	 * Show Control Panel
	 * 
	 * @access public
	 * @param $cachable string
	 *       	 the view output will be cached
	 * @return void
	 */
	function display($cachable = false, $urlparams = false) {
		parent::display (); 
	}
}