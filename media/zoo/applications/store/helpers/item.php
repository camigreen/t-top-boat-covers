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

	public function __construct($app) {
		parent::__construct($app);
		$this->app->loader->register('StoreItem','classes:storeitem.php');
	}

	public function create($item) {
		$storeItem = new StoreItem($this->app, $item);
		return $storeItem;
	}
}

?>