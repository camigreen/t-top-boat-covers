<?php defined('_JEXEC') or die('Restricted access');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author Shawn
 */
class AccountHelper extends AppHelper {

	protected $_accounts = array();

	public function __construct($app) {
		parent::__construct($app);

		$this->app->loader->register('Account', 'classes:account.php');
		$this->table = $this->app->table->account;

        
	}

	public function get($id) {

		if (!isset($this->_accounts[$id])) {
			$account = $this->table->get($id);
			if(!$account) {
				$account = $this->create();
			}
			$this->_accounts[$id] = $account;
		}
		
		return $this->_accounts[$id]; 
	}

	public function create($type = 'default', $args = array()) {

		if($type == 'default') {
			$class = 'Account';
			$classname = 'default';
		} else {
			list($classname, $type) = explode('.', $type.'.',3);
			$class = $classname.'Account';
			$this->app->loader->register($class, 'classes:accounts/'.strtolower(basename($class,'Account')).'.php');
		}

		$account = new $class();
		$account->type = $classname.($type ? '.'.$type : '');
		$account->app = $this->app;

		
		// trigger init event
		$this->app->event->dispatcher->notify($this->app->event->create($account, 'account:init'));
		
		if(!empty($args)) {
			$account->bind($args);
		}
		return $account;

	}

	public function getByTypes() {
		return $this->app->table->account->all();
	}

	public function getStoreAccount() {
		return $this->table->find('first', array('conditions' => "type = 'store'"));
	}

	public function getByUser($user = null) {

		$db = $this->app->database;

		$id = $db->queryResult('SELECT parent FROM #__zoo_account_user_map WHERE child = '.$user->id);
		if(!$id) {
			return null;
		} 

		$account = $this->get($id);

		return $account;
	}

	public function getUsersByParent($parent = null, $conditions = array()) {

		$db = $this->app->database;
		
		$query = 'SELECT child FROM #__zoo_account_map WHERE parent = '.$parent->id;

		$users = $db->queryResultArray($query);

		$conditions[] = 'id IN ('.implode(',',$users).')';
		
		$options['conditions'] = implode(' AND ',$conditions);
		// var_dump($options);
		// return;

		$accounts = $this->table->all($options);
		return $accounts;
	}

	public function getUnassignedOEMs($options = null) {
		$oems = $this->app->table->account->getUnassignedOEMs();
		$assignments = array();
        foreach($oems as $oem) {
            if($oem->parent) {
                $assignments[$oem->parent][$oem->id] = $oem;
            } else {
                $assignments['unassigned'][$oem->id] = $oem;
            }
        }
        return $assignments;

	}

	/**
	 * Evaluates user permission
	 *
	 * @param JUser $user User Object
	 * @param int $asset_id
	 *
	 * @return boolean True if user has permission
	 *
	 * @since 3.2
	 */
	public function isAdmin($user = null, $asset_id = 0) {
		return $this->authorise($user, 'core.admin', $asset_id);
	}

	/**
	 * Evaluates user permission
	 *
	 * @param JUser $user User Object
	 * @param int $asset_id
	 * @param int $created_by
	 *
	 * @return boolean True if user has permission
	 *
	 * @since 3.2
	 */
	public function canEdit($user = null, $asset_id = 0, $created_by = 0) {
		
		if(!$user) {
			$user = $this->app->customer->getUser();
		}
		$account = $this->app->customer->get();

		return $this->isAdmin($user, $asset_id) || $this->authorise($user, 'account.edit', $asset_id) || ($created_by === $account->id && $user->authorise('account.edit.own', $asset_id));
	}


	/**
	 * Evaluates user permission
	 *
	 * @param JUser $user User Object
	 * @param string $action
	 * @param int $asset_id
	 *
	 * @return boolean True if user has permission
	 *
	 * @since 3.2
	 */
	protected function authorise($user, $action, $asset_id) {
		if (!$asset_id) {
			$asset_id = 'com_zoo';
		}
		if (is_null($user)) {
			$user = $this->get();
		}

		return (bool) $user->authorise($action, $asset_id);
	}

    

    
}