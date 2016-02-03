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
        $this->app->loader->register('Price','store.lib:/price/price.php');

    }

    public function create(StoreItem $item, $resource = null) {
        // if(!isset($this->_prices[$item->sku])) {
        //     $this->_prices[$item->sku] = new Price($this->app, $item, $resource);
        // }
        // var_dump($this->_prices);
        // return $this->_prices[$item->sku];
        return new Price($this->app, $item, $resource);
    }

}