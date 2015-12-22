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
    
    public function getParent() {
        if(!$this->isRegistered()) {
            return $this->_account;
        } 
        return $this->_account->getParentAccount();
    }

    public function get() {
        if(!$this->_account) {
            $user = $this->app->user->get();
            $this->_account = $this->app->account->getByUser($user);
        }
        if(!$this->_account) {
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
        return $this->get()->getUser();
    }

    public function isRegistered() {
        return ($this->get()->type != 'user.public');
    }

    public function isReseller() {
        return $this->getAccount()->isReseller();
    }

    public function getAccountTerms() {
        return $this->_account->params->get('terms', 'DUR');
    }

    public function getDiscountRate() {
        return $this->app->number->toPercentage($this->_account->params->get('discount'),0);
    }
    
}
