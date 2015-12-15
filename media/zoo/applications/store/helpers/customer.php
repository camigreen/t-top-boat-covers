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
    
    
    public function getAccount() {
        if($this->isRegistered()) {
            $this->_account = $this->_user->getParentAccount();
        } else {
            return $this->_user;
        }

        
        return $this->_account;
        
    }

    public function getUser() {
        if(!$this->_user) {
            $user = $this->app->user->get();
            $accounts = $this->app->table->account->all(array('conditions' => "type LIKE 'user.%'"));
            foreach($accounts as $account) {
                if($account->params->get('user') == $user->id) {
                    $this->_user = $this->app->account->get($account->id);
                }
            }
        }
        if(!$this->_user) {
            $this->_user = $this->app->account->create('user.public');
        }
        return $this->_user;
    }

    public function isRegistered() {
        return $this->getUser()->type != 'user.public' ? true : false;
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
