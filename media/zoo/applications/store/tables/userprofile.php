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
class UserProfileTable extends AppTable {

	public function __construct($app) {
		parent::__construct($app, '#__zoo_userprofile');
		
		$this->app->loader->register('UserProfile','classes:userprofile.php');
	}

	public function get($id, $new = false) {

		$object = parent::get($id, $new);

		if(!$object) {
			$new = true;
			$object = $this->app->object->create('userprofile');
		} else {
			$new = false;
		}

		// trigger save event
			$this->app->event->dispatcher->notify($this->app->event->create($object, 'userprofile:init', compact('new')));

		return $object;

	}

	/**
	 * Get all the results of the query built using the options passed
	 *
	 * @see _select()
	 *
	 * @param array $options The list of conditions for the query
	 *
	 * @return array The list of objects representing the table record
	 */
	public function all($options = null) {
		$profiles = parent::all($options);

		foreach($profiles as $profile) {
			$new = !$profile->id  ? true : false;

			// trigger save event
			$this->app->event->dispatcher->notify($this->app->event->create($profile, 'userprofile:init', compact('new')));

		}
		return $profiles;
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
		$this->app->event->dispatcher->notify($this->app->event->create($object, 'userprofile:saved', compact('new')));

		return $result;
	}

	public function getUserAssignments($options = null) {
		$query = 'SELECT b.parent, a.* FROM #__zoo_userprofile a LEFT JOIN (SELECT * FROM #__zoo_account_user_map) b ON a.id = b.child';
        return $this->_queryObjectList($query);
	}
}

/*
	Class: ItemTableException
*/
class UserProfileTableException extends AppException {}