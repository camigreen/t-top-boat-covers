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
class Customer extends Store {
    
    protected $id;
    
    protected $billing;
    
    protected $shipping;
    
    protected $email;
    
    protected $confirm_email;
    
    protected $ip_address;
    
    
    public function __construct() {
        
    }
    
    public function set($resource, $value) {
        if(is_array($value)) {
            $value = $this->array2object($value);
        }
        parent::set($resource, $value);
        return $this;
    }

}
