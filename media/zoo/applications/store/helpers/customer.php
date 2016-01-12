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
class CustomerHelper extends AppHelper {

    protected $_account;

    protected $_user;

    public function __construct($app) {
        parent::__construct($app);
        $this->userhelper = $this->app->user;
        $this->_user = $this->userhelper->get();
        $this->application = $this->app->zoo->getApplication();
    }

    /**
     * Get the helper name
     *
     * @return string The name of the helper
     *
     * @since 1.0.0
     */
    public function getName() {
        return 'customer';
    }
    
    public function getParent() {
        if(!$this->isRegistered()) {
            return $this->_account;
        } 
        return $this->_account->getParentAccount();
    }

    public function get($id = null) {

        if(!$this->_account) {
            $this->_account = $this->app->account->getByUser($this->_user);
        }
        if($this->isGuest() || !$this->_account) {
            $this->_account = $this->app->account->create('user.public');
        }
        return $this->_account;
    }

    /**
     * Describe the Function
     *
     * @param     datatype        Description of the parameter.
     *
     * @return     datatype    Description of the value returned.
     *
     * @since 1.0
     */
    public function getUser() {
        return $this->_user;
    }

    public function isRegistered() {
        return ($this->get()->type != 'user.public');
    }

    public function isReseller() {
        return $this->getParent()->isReseller();
    }

    public function getAccountTerms() {
        return $this->_account->params->get('terms', 'DUR');
    }

    public function getDiscountRate() {
        return $this->app->number->toPercentage($this->_account->params->get('discount'),0);
    }

    public function isGuest() {
        return (bool) $this->_user->guest;
    }
    /**
     * Check if the user is a joomla super administrator
     *
     * @return boolean If the user is a super administrator
     *
     * @since 1.0.0
     */
    public function isJoomlaSuperAdmin() {
        return $this->authorise('core.admin', 'root.1');
    }
    /**
     * Check if a user is a joomla administrator
     *
     * @return boolean if the user is an administrator
     *
     * @since 1.0.0
     */
    public function isJoomlaAdmin() {
        return $this->authorise('core.login.admin', 'root.1');
    }
        /**
     * Check if a user can access a resource
     *
     * @param int $access The access level to check against
     *
     * @return boolean If the user have the rights to access that level
     *
     * @since 1.0.0
     */
    public function canAccess($access = 0) {

        if (is_null($this->_user)) {
            $this->_user = $this->userhelper->get();
        }

        return in_array($access, $this->_user->getAuthorisedViewLevels());

    }

        /**
     * Check if a user is a joomla administrator
     *
     * @return boolean if the user is an administrator
     *
     * @since 1.0.0
     */
    public function isAccountAdmin() {
        return $this->authorise('account.admin', 'com_zoo');
    }

    /**
     * Check if a user is a joomla administrator
     *
     * @return boolean if the user is an administrator
     *
     * @since 1.0.0
     */
    public function isStoreAdmin() {
        return $this->authorise('store.admin', 'com_zoo.application.'.$this->application->id.'store');
    }

    /**
     * Evaluates user permission
     *
     * @param int $asset_id
     * @param int $created_by
     *
     * @return boolean True if user has permission
     *
     * @since 3.2
     */
    public function canEdit($asset_id = 0, $created_by = 0) {
        if (is_null($this->_user)) {
            $this->_user = $this->getUser();
        }
        return $this->isAdmin($this->_user, $asset_id) || $this->authorise('core.edit', $asset_id) || ($created_by === $this->_user->id && $this->authorise('core.edit.own', $asset_id));
    }
    /**
     * Evaluates user permission
     *
     * @param int $asset_id
     * @param int $created_by
     *
     * @return boolean True if user has permission
     *
     * @since 3.2
     */
    public function canEditOwn($action, $asset_id = 0, $created_by = 0) {
        if (is_null($this->_user)) {
            $this->_user = $this->get();
        }
        return $this->isAdmin($this->_user, $asset_id) || ($created_by === $this->_account->id && $this->authorise($action.'.edit.own', $asset_id));
    }

    /**
     * Evaluates user permission
     *
     * @param int $asset_id
     * @param int $created_by
     *
     * @return boolean True if user has permission
     *
     * @since 3.2
     */
    public function canEditParentAccount($asset_id = 0) {
        if (is_null($this->_user)) {
            $this->_user = $this->get();
        }
        return $this->isAdmin($this->_user, $asset_id) || $this->authorise('account.parent.edit.own', $asset_id);
    }

    public function checkPermissions($access= null) {
        if(!$access) {
            return true;
        }
        switch($access) {
            case 'user':
                
                break;
            case 'admin':
                break;
            case 'storeadmin':
                break;
            default:
                $result = false;
        }

        return $result;
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
    public function canEditState($action, $asset_id = 0) {
        return $this->isAdmin($this->_user, $asset_id) || $this->authorise($action.'.edit.state', $asset_id);
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
    public function canCreate($asset_id = 0) {
        return $this->isAdmin($this->_user, $asset_id) || $this->authorise('core.create', $asset_id);
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
    public function canDelete($asset_id = 0) {
        return $this->isAdmin($this->_user, $asset_id) || $this->authorise('core.delete', $asset_id);
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
    public function canManage($asset_id = 0) {
        return $this->isAdmin($this->_user, $asset_id) || $this->authorise('core.manage', $asset_id);
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
    public function isAdmin($asset_id = 0) {
        return $this->authorise($this->_user, 'core.admin', $asset_id);
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
    public function canManageCategories($asset_id = 0) {
        return $this->isAdmin($this->_user, $asset_id) ||  $this->authorise('zoo.categories.manage', $asset_id);
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
    public function canManageComments($asset_id = 0) {
        return $this->isAdmin($this->_user, $asset_id) ||  $this->authorise('zoo.comments.manage', $asset_id);
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
    public function canManageFrontpage($asset_id = 0) {
        return $this->isAdmin($this->_user, $asset_id) ||  $this->authorise('zoo.frontpage.manage', $asset_id);
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
    public function canManageTags($asset_id = 0) {
        return $this->isAdmin($this->_user, $asset_id) || $this->authorise('zoo.tags.manage', $asset_id);
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
    protected function authorise($action, $asset_id) {
        if(!$asset_id) {
            $asset_id = 'com_zoo';
        } else {
            $asset_id = 'com_zoo.application'.$this->application->id.'.'.$asset_id;
        }
        if (is_null($this->_user)) {
            $this->_user = $this->userhelper->get();
        }

        return (bool) $this->_user->authorise($action, $asset_id);
    }
}
