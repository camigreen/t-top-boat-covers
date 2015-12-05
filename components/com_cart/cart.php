<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// load config
require_once(JPATH_ADMINISTRATOR.'/components/com_cart/config.php');

// get ZOO app
$cart = App::getInstance('cart');

// init vars
$path = dirname(__FILE__);

// register paths
$cart->path->register($path.'/assets', 'assets');
$cart->path->register($path.'/controllers', 'controllers');

// add default js


try {

	// load and dispatch application
	if ($application = $cart->cart->getApplication()) {
		$application->dispatch();
	} else {
		return $zoo->error->raiseError(404, JText::_('Application not found'));
	}

} catch (AppException $e) {
	$cart->error->raiseError(500, $e);
}