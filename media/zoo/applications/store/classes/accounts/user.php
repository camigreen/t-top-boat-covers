<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author Shawn Gibbons
 */
class UserAccount extends Account {

    public $name;

    public $type = 'user';

    protected $_user;

    protected $_userGroups = array(26);

    public function __construct() {
        parent::__construct();
    }

    public function save() {
        
        $this->_user->save();
        JUserHelper::setUserGroups($this->_user->id, $this->_userGroups);
        
        parent::save();
        $uid = $this->params->get('user');
        if(!$uid || $uid != $this->_user->id) {
            $this->params->set('user', $this->_user->id);
            $this->mapUser();
        }
        
        return $this;

    }

    public function bind($data = array()) {

        if(isset($data['user'])) {
            $user = $this->getUser();
            $user->bind($data['user']);
            if(isset($data['user']['name'])) {
                $this->name = $data['user']['name'];
            }
            if(isset($data['user']['groups'])) {
                $this->_userGroups = $data['user']['groups']; 
            }
            
        }
        parent::bind($data);

    }

    public function loadUser() {

        if(empty($this->_user) && $this->id) {

            $db = $this->app->database;

            $uid = $db->queryResult('SELECT child FROM #__zoo_account_user_map WHERE parent = '.$this->id);
            if($uid) {
                $this->_user = $this->app->user->get($uid);
                $this->name = $this->_user->name;
            } else {
                $this->_user = new JUser();
            }

            $this->_userGroups = $this->_user->getAuthorisedGroups();
        } else {
            $this->_user = new JUser();
        }
        
        return $this;
    }

    public function getUser() {
        return $this->loadUser()->_user;
    }

    public function mapUser() {

        // Remove all mappings where this account is the child from the database.
        $query = 'DELETE FROM #__zoo_account_user_map WHERE parent = '.$this->id;
        $this->app->database->query($query);

        // Map joomla user to the user accounts in the database.
        $query = 'INSERT INTO #__zoo_account_user_map (parent, child) VALUES ('.$this->id.','.$this->params->get('user').')';
        $this->app->database->query($query);
    }

    public function getParentAccount() {
        $parents = array_values($this->getParents());
        
        if(empty($parents)) {
            return $this;
        } else {
            list($parent) = $parents;
        }
        return $parent;
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
    public function canEdit() {
        return $this->app->customer->canEdit($this->getAssetName(), $this->getUser()->id);
    }

    /**
     * Evaluates user permission
     *
     * @param int $asset_id
     *
     * @return boolean True if user has permission
     *
     * @since 3.2
     */
    public function canEditState($user = null) {
        return $this->app->user->canEditState($user, $this->getAssetName());
    }

    /**
     * Evaluates user permission
     *
     * @param int $asset_id
     *
     * @return boolean True if user has permission
     *
     * @since 3.2
     */
    public function canCreate() {
        return $this->app->user->canCreate($this->getUser(), $this->getAssetName());
    }

    /**
     * Evaluates user permission
     *
     * @param int $asset_id
     *
     * @return boolean True if user has permission
     *
     * @since 3.2
     */
    public function canDelete() {
        return $this->canEdit($this->getUser()) && $this->app->user->canDelete($this->getUser(), $this->getAssetName());
    }

    /**
     * Evaluates user permission
     *
     * @param int $asset_id
     *
     * @return boolean True if user has permission
     *
     * @since 3.2
     */
    public function canManage($user = null) {
        return $this->app->user->canManage($user, $this->getAssetName());
    }


}