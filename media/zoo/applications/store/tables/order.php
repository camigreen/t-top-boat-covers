<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

/*
	Class: ItemTable
		The table class for items.
*/
class OrderTable extends AppTable {

	public function __construct($app) {
		parent::__construct($app, '#__zoo_order');
	}


	/*
		Function: save
			Override. Save object to database table.

		Returns:
			Boolean.
	*/
	public function save($object) {

		$object->orderDate = $this->app->date->create($object->orderDate)->toSQL();
		parent::save($object);
		return $object;
	}
}

/*
	Class: ItemTableException
*/
class ItemTableException extends AppException {}