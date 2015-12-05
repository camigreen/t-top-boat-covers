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
class OrderHelper extends AppHelper {
    
    protected $_order;
    
    public function __construct($app) {
        parent::__construct($app);
    }
    
    public function create($id = null) {

        //$this->app->session->clear('order','checkout');
    	$this->app->loader->register('CartItem','classes:cartitem.php');
    	if ($id || $id != 0) {
    		$this->_order = $this->app->table->order->get($id);

            if(is_string($this->_order->billing) || is_null($this->_order->billing)) {
                $this->_order->billing = $this->app->data->create($this->_order->billing);
            }
            if(is_string($this->_order->shipping) || is_null($this->_order->shipping)) {
                $this->_order->shipping = $this->app->data->create($this->_order->shipping);
            }
            if(is_string($this->_order->items) || is_null($this->_order->items)) {
                $items = $this->app->data->create($this->_order->items);
                $this->_order->items = $this->app->data->create();
                foreach($items as $key => $item) {
                    $_item = new CartItem($this->app, $item);
                    $this->_order->items->set($key, $_item);
                }
            }
            if(is_string($this->_order->creditCard) || is_null($this->_order->creditCard)) {
                $this->_order->creditCard = $this->app->data->create($this->_order->creditCard, 'creditCard');
            }

            $this->_order->ip = $this->app->useragent->ip();

    	} else {
            $this->_order = $this->loadFromSession();
        }
        
        return $this->_order;
    }

    protected function loadFromSession() {
        $excluded_fields = array('items','testing');
        $_order = $this->app->object->create('order');

        $order = $this->app->session->get('order',array(),'checkout');

        $order = $this->app->data->create($order);

        foreach($order as $key => $value) {
            if(!in_array($key, $excluded_fields)) {
                $_order->$key = $value;
            }
            
        }
        $_order->billing = $this->app->data->create($_order->billing);
        $_order->shipping = $this->app->data->create($_order->shipping);
        $_order->creditCard = $this->app->data->create($_order->creditCard, 'creditcard');
        $_order->items = $this->app->cart->get();
        $_order->ip = $this->app->useragent->ip();

        return $_order;

    }
    
}
