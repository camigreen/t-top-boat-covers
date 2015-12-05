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
class CashRegisterHelper extends AppHelper {
    
    
    public $CR;
    
    public function start() {
        $this->app->loader->register('CashRegister','classes:store/cashregister.php');
        $this->CR = new CashRegister($this->app);

        return $this->CR;
    }
}

class StoreAppException extends AppException {}

