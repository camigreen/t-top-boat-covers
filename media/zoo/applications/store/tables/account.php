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
class AccountTable extends AppTable {

	public function __construct($app) {
		parent::__construct($app, '#__zoo_account');
		
		$this->app->loader->register('Account','classes:account.php');
	}


	protected function _initObject($object) {

		parent::_initObject($object);
	
		// add to cache
		$key_name = $this->key;

		if ($object->$key_name && !key_exists($object->$key_name, $this->_objects)) {
			$this->_objects[$object->$key_name] = $object;
		}

		// trigger init event
		$this->app->event->dispatcher->notify($this->app->event->create($object, 'account:init'));

		return $object;
	}

	/**
	 * Performs a query to the database and returns the representing object
	 *
	 * This method will run the query and then build the object that represents
	 * the record of the table. It will also init the object with the basic properties
	 * like the reference to the global App object
	 *
	 * @param string $query The query to perform
	 *
	 * @return object The object representing the record
	 */
	protected function _queryObject($query) {

		// query database
		$result = $this->database->query($query);

		// fetch object and execute init callback
		$object = null;
		if ($object = $this->database->fetchObject($result)) {
			list($type) = explode('.', $object->type,2);
			$class = $type."Account";

			$this->app->loader->register($class, 'classes:accounts/'.strtolower($type).'.php');
			$obj = new $class();
			foreach($object as $key => $value) {
				if(property_exists($obj, $key)) {
					$obj->$key = $value;
				}
			}
			$object = $this->_initObject($obj);
		}

		$this->database->freeResult($result);
		return $object;
	}

	/**
	 * Performs a query to the database and returns the representing list of objects
	 *
	 * This method will run the query and then build the list of objects that represent
	 * the records of the table. It will also init the objects with the basic properties
	 * like the reference to the global App object
	 *
	 * @param string $query The query to perform
	 *
	 * @return array The list of objects representing the records
	 */
	protected function _queryObjectList($query) {

		// query database
		$result = $this->database->query($query);

		// fetch objects and execute init callback
		$objects = array();
		while ($object = $this->database->fetchObject($result)) {
			list($type) = explode('.', $object->type,2);
			$class = $type."Account";
			$this->app->loader->register($class, 'classes:accounts/'.strtolower($type).'.php');
			$obj = new $class();
			foreach($object as $key => $value) {
				if(property_exists($obj, $key)) {
					$obj->$key = $value;
				}
			}
			$objects[$obj->id] = $this->_initObject($obj);
		}

		$this->database->freeResult($result);
		return $objects;
	}

	/*
		Function: save
			Override. Save object to database table.

		Returns:
			Boolean.
	*/
	public function save($object) {

		$new = !(bool) $object->id;

		// first save to get id
		if (empty($object->id)) {
			parent::save($object);
		}

		$result = parent::save($object);

		// trigger save event
		$this->app->event->dispatcher->notify($this->app->event->create($object, 'account:saved', compact('new')));

		return $result;
	}

	public function getUnassignedAccounts() {
		$query = 'SELECT b.parent, a.* FROM #__zoo_account a LEFT JOIN (SELECT * FROM #__zoo_account_map) b ON a.id = b.child WHERE b.parent IS NULL';
        return $this->_queryObjectList($query);
	}

	public function getUnassignedAccountsByType($type) {
		$query = 'SELECT b.parent, a.* FROM #__zoo_account a LEFT JOIN (SELECT * FROM #__zoo_account_map) b ON a.id = b.child WHERE b.parent IS NULL AND a.type = "'.$type.'"';
        return $this->_queryObjectList($query);
	}
}

/*
	Class: ItemTableException
*/
class AccountTableException extends AppException {}