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
class OrderDevHelper extends AppHelper {
    
    protected $_order;
    protected $table;
    
    public function __construct($app) {
        parent::__construct($app);  
        $this->app->loader->register('OrderDev','classes:orderdev.php');
        $this->table = $this->app->table->orderdev;

    }

    public function get($id) {

        if (isset($this->_order[$id])) {
            return $this->_order[$id];
        } 
        
        $order = $this->table->get($id);

        // trigger the init event
        $this->app->event->dispatcher->notify($this->app->event->create($order, 'order:init'));

        $this->_order[$id] = $order;

        return $this->_order[$id];
    }
    
    public function create() {
        $order = new OrderDev;
        $order_session = $this->app->session->get('order', array(), 'checkout');
        $_order = $this->app->parameter->create($order_session);
        foreach($_order as $key => $value) {
            if(property_exists($order, $key)) {
                $order->$key = $value;
            }
        }
        $order->app = $this->app;
        // trigger the init event
        $this->app->event->dispatcher->notify($this->app->event->create($order, 'order:init'));

        $order->params->set('payment.status', 1);

        return $order;
    }

}
