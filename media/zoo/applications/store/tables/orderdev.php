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
class OrderDevTable extends AppTable {

	public function __construct($app) {
		parent::__construct($app, '#__zoo_orderdev');
	}


	/*
		Function: save
			Override. Save object to database table.

		Returns:
			Boolean.
	*/
	public function save($object) {
		$result = parent::save($object);
		return $result;
	}
}

/*
	Class: ItemTableException
*/
class OrderDevTableException extends AppException {}