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

    public function __construct() {
        parent::__construct();
    }

    public function save() {

        parent::save();
        $this->_user->save();

    }

    public function bind($data = array()) {

        if(isset($data['user'])) {
            $user = $this->getUser();
            $user->bind($data['user']);
            if(isset($data['user']['name'])) {
                $this->name = $data['user']['name'];
            }
        }
        parent::bind($data);

    }

    public function loadUser() {
        if(!$this->params->get('user')) {
            $this->_user = new JUser();
        }

        if(empty($this->_user)) {
            $this->_user = $this->app->user->get($this->params->get('user'));
        }
        $this->name = $this->_user->name;
        return $this;
    }

    public function getUser() {
        $this->loadUser();
        return $this->_user;
    }

    public function getParentAccount() {
        $parents = array_values($this->getParents());
        
        return $parents[0];
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