<?php defined('_JEXEC') or die('Restricted access');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// $zoo = App::getInstance('zoo');
// $zoo->loader->register('UserAppHelper', 'helpers:user.php');
/**
 * Description of newPHPClass
 *
 * @author Shawn
 */
class SalespersonHelper extends UserAppHelper {
    
    protected $_salesperson;
    

    public function get($id = null) {
        $user = $this->_get();
        $asset_id = $this->app->zoo->getApplication()->asset_id;
        if($this->canCreateOrders($user,$asset_id)) {
            $this->_salesperson = $user;
        } else {
            $this->_salesperson = false;
        }
        return $this->_salesperson;
    }

    public function _get($id = null) {
        return parent::get($id);
    }

    public function getName() {
        return 'salesperson';
    }

    public function canCreateOrders($user = null, $asset_id = 0) {
        if(is_null($this->_salesperson)) {
            $user = $this->_get();
        } else {
            $user = $this->_salesperson;
        }
        if(!$user){
            return false;
        }
        return $this->isAdmin($user, $asset_id) || $this->authorise($user, 'order.create', $asset_id);

    }
    public function canEditOrders($user = null, $asset_id = 0) {
        if(is_null($this->_salesperson)) {
            $user = $this->_get();
        } else {
            $user = $this->_salesperson;
        }
        return $this->isAdmin($user, $asset_id) || $this->authorise($user, 'order.edit', $asset_id);

    }
    public function canMakeSales($user) {}

}

    