<?php defined('_JEXEC') or die('Restricted access');

/**
 * @package   Package Name
 * @author    Shawn Gibbons http://www.palmettoimages.com
 * @copyright Copyright (C) Shawn Gibbons
 * @license   
 */

/**
 * Class Description
 *
 * @package Class Package
 */
class ItemHelper extends AppHelper {

	/**
	 * @var [array]
	 */
	protected $_items = array();	
	

	public function __construct($app) {
		parent::__construct($app);
		$this->app->loader->register('StoreItem','classes:storeitem.php');
	}

	public function create($item) {
		//var_dump($item);
		// if(is_string($item) || is_array($item)) {
		// 	$item = $this->app->parameter->create($item);
		// }
		// if(!isset($item->sku) || !isset($this->_items[$item->sku])) {
		// 	var_dump($item);
		// 	$item = new StoreItem($this->app, $item);
		// 	$this->_items[$item->sku] = $item;
		// }
		$storeItem = new StoreItem($this->app, $item);
		
		// fire event
        $this->app->event->dispatcher->notify($this->app->event->create($storeItem, 'storeitem:init'));

		return $storeItem;
	}
}

?>