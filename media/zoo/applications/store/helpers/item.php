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
		if(!isset($this->_items[$item->id])) {
			$this->_items[$item->id] = new StoreItem($this->app, $item);
		}
		
		// fire event
        $this->app->event->dispatcher->notify($this->app->event->create($this->_items[$item->id], 'storeitem:init'));

		return $this->_items[$item->id];
	}
}

?>