<?php
/**
 * Hello World! Module Entry Point
 * 
 * @package    Joomla.Tutorials
 * @subpackage Modules
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:modules/
 * @license        GNU/GPL, see LICENSE.php
 * mod_helloworld is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// load config
require_once(JPATH_ADMINISTRATOR.'/components/com_zoo/config.php');

// get app
$zoo = App::getInstance('zoo');

// load zoo frontend language file
$zoo->system->language->load('com_zoo');

// init vars
$path = dirname(__FILE__);

//register base path
$zoo->path->register($path, 'mod_zoocart');
$zoo->path->register($path.'/assets','assets');

$zoo->document->addScript('assets:js/jquery.cookie.js');
$zoo->document->addScript('assets:js/cart.js');
$zoo->document->addStylesheet('assets:css/cart.css');
$zoo->document->addStylesheet('media/zoo/applications/store/assets/css/ttop.css');

$layout = $params->get('layout', 'default');

if ($application = $zoo->table->application->get($params->get('application', 0))) {
	include(JModuleHelper::getLayoutPath('mod_zoocart', $layout));
}




?>