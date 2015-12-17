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

    protected $_userGroups = array();

    public function __construct() {
        parent::__construct();
    }

    public function save() {
        
        $this->_user->save();
        JUserHelper::setUserGroups($this->_user->id, $this->_userGroups);
        $this->params->set('user', $this->_user->id);
        parent::save();
        
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

        if(empty($this->_user)) {
            $db = $this->app->database;
            if($this->id) {
                $id = $db->queryResult('SELECT child FROM #__zoo_account_user_map WHERE parent = '.$this->id);
                
            } else {
                $id = null;
            }

            if($id) {
                $this->_user = $this->app->user->get($id);
                $this->name = $this->_user->name;
            } else {
                $this->_user = new JUser();
            }

            $this->_userGroups = $this->_user->getAuthorisedGroups();
        }
        
        return $this;
    }

    public function getUser() {
        return $this->loadUser()->_user;
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

    public function getAssetName() {
        return 'com_zoo';
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
    public function canEdit($user = null) {
        $superadmin = $this->_user->superadmin ? $user->superadmin : true;
        return $superadmin && $this->app->user->canEdit($user, $this->getAssetName());
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