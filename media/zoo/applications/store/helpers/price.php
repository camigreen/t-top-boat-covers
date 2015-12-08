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
class PriceHelper extends AppHelper {

    /**
     * @var [array]
     */
    protected $_prices = array();
    

    public function __construct($app) {
        parent::__construct($app);
        $this->app->loader->register('Price','classes:price.php');

    }

    public function create($item, $resource = null) {
        if(!isset($this->_prices[$item])) {
            $this->_prices[$item] = new Price($this->app, $item, $resource);
        }

        return $this->_prices[$item];
    }

}