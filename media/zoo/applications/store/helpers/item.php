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

	public function create($item, $type = null) {
		if(!isset($item->sku) || !isset($this->_items[$item->sku])) {
			$class = $type.'StoreItem';
			if($type) {
				if(file_exists($this->app->path->path('classes:store/items/'.$type.'.php'))) {
					$this->app->loader->register($class, 'classes:store/items/'.$type.'.php');
					$storeItem = new $class($this->app);
				} else {
					$storeItem = new StoreItem($this->app);
				}
			} else {
				$storeItem = new StoreItem($this->app);
			} 

			$storeItem->importItem($item);

			// fire event
	    	$this->app->event->dispatcher->notify($this->app->event->create($storeItem, 'storeitem:init'));

	    	$this->_items[$storeItem->sku] = $storeItem;

	    	return $this->_items[$storeItem->sku];
	    }

		return $this->_items[$item->sku];
	}
}

?>