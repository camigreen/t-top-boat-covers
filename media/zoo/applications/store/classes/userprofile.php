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
class UserProfile {

    public $id;

    public $created;

    public $created_by;

    public $modified;

    public $modified_by;

    public $elements;

    public $status = 0;

    public $access = 1;

    protected $_user;

    public $app;

    public function __construct() {

        // get app instance
        $app = App::getInstance('zoo');

        // decorate data as object
        $this->elements = $app->parameter->create($this->elements);
        $this->table = $app->table->userprofile;

    }

    /**
     * Save the user profile.
     *
     * @return boolean       If the user can access the item
     *
     * @since 2.0
     */
    public function save() {

        $result = $this->_user->save();
        if (!$result) {
            return $this->app->error->raiseError(500, JText::_('An error occurred while saving the user object.'));
        }

        $this->user_id = $this->_user->id;

        // var_dump($this);
        // return;
        $result = $this->table->save($this);

        if (!$result) {
            return $this->app->error->raiseError(500, JText::_('An error occurred while saving the user profile.'));
        }

        return $result;
        
    }

    public function setUser(JUser $user) {
        $this->_user = $user;
        $this->_user->password = null;
    }

    /**
     * Bind data to the userprofile object.
     *
     *  @param array   The binding data.
     *
     * @return boolean       If the user can access the item
     *
     * @since 2.0
     */
    public function bind($data = array()) {

        // bind core
        if(isset($data['core'])) {
            foreach($data['core'] as $key => $value) {
                $this->$key = $value;
            }
        }

        // bind user
        if(isset($data['user'])) {
            $this->_user->bind($data['user']);
        }


        // bind elements
        if(isset($data['elements'])) {
            foreach($data['elements'] as $key => $value) {
                $this->elements->set($key, $value);
            }
        }


        
        return $this;

        
    }



    /**
     * Check if the given usen can access this item
     *
     * @param  JUser $user The user to check
     *
     * @return boolean       If the user can access the item
     *
     * @since 2.0
     */
    public function canAccess($access = 0) {
        return in_array($access, $this->_user->getAuthorisedViewLevels());
    }

    /**
     * Gets the user object
     *
     * @return object  JUSer  The user object assigned to the profile
     *
     * @since 1.0
     */
    public function getUser() {
        if (empty($this->_user)) {
            $this->_user = $this->app->user->get($this->user_id);
        }
        return $this->_user;
    }

    /**
     * Set the status for the account object
     *
     * @param  string $state The parameter to retrieve
     * 
     * @param  boolean $save Automatically save to the database? default = false
     *
     * @return Account $this for chaining support.
     *
     * @since 1.0
     */
    public function setState($state, $save = false) {
        if ($this->state != $state) {

            // set state
            $old_state   = $this->state;
            $this->state = $state;

            // autosave comment ?
            if ($save) {
                $this->app->table->account->save($this);
            }

            // fire event
            $this->app->event->dispatcher->notify($this->app->event->create($this, 'account:stateChanged', compact('old_state')));
        }

        return $this;
    }

        /**
     * Get the state account object
     *
     * @return string  The human readable value of the account state.
     *
     * @since 1.0
     */
    public function getState() {
        return JText::_($this->app->status->get('account', $this->state));
    }

    /**
     * Gets the user object
     *
     * @return object  JUSer  The user object assigned to the profile
     *
     * @since 1.0
     */
    public function isCurrentUser() {
        $cUser = $this->app->session->get('user')->id;
        return $cUser == $this->id ? true : false;
    }

    /**
     * Gets the account object
     *
     * @return object  Account  The account object assigned to this user profile
     *
     * @since 1.0
     */
    public function getAccount() {
        return $this->app->userprofile->getAccount($this);
    }

    /**
     * Get the given parameter for the account object
     *
     * @param  string $name The parameter to retrieve
     *
     * @return mixed  The value of the parameter. Returns null if parameter does not exist
     *
     * @since 1.0
     */
    public function getParam($name) {
        return $this->params->get($name);
    }

    /**
     * Set the given parameter for the account object
     *
     * @param  string $name The parameter to set
     *
     * @param  mixed  $value The value of the parameter
     *
     * @return mixed  The value of the parameter.
     *
     * @since 1.0
     */
    public function setParam($name, $value) {
        return $this->params->set($name, $value);
    }

    public function removeAccountMap() {
        if(!$this->id) {
            return;
        }
        $query = 'DELETE FROM #__zoo_account_user_map WHERE child = '.$this->id;
        $this->app->database->query($query);

        return $this;
    }

    public function mapToAccount($aid) {
        
        $query = 'DELETE FROM #__zoo_account_user_map WHERE child = '.$this->id;
        $this->app->database->query($query);

        $query = 'INSERT INTO #__zoo_account_user_map (parent, child) VALUES ('.$aid.','.$this->id.')';
        $this->app->database->query($query);
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

    