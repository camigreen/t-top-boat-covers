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
class CartHelper extends AppHelper {
    
    protected $_items;
    
    public function __construct($app) {
        parent::__construct($app);

        $this->app->loader->register('CartItem','classes:cartitem.php');

        $this->_items = $this->app->data->create();
        $cart = $this->app->session->get('cart',array(),'checkout');

        $items = $this->app->data->create($cart);
        $this->app->log->createLogger('file',array('media/zoo/applications/store/logs/cart/'.date('Y-m-d').'.txt'));
        //$this->app->log->createLogger('email',array('sgibbons@palmettoimages.com'));
        $this->add($items, true);

    }

    public function get($key = null) {
    	if($key) {
            return $this->_items[$key];
        }

        return $this->_items;
        
    }

    public function add($items, $imported = false) {
    	foreach($items as $key => $item) {
    		$item_x = new CartItem($this->app, $item);
            if (array_key_exists($item_x->getSKU(), $this->_items)) {
                $this->_items[$item_x->getSKU()]->qty += $item_x->qty;
            } else {
                $this->_items[$item_x->getSKU()] = $item_x;
                $this->_items[$item_x->getSKU()]->imported = $imported;
            }
            if (!$imported) {
                $this->app->log->notice($item_x->toLog(),'Cart Item Added');
            }
    	}
        return $this->updateSession();
    }

    protected function createItem($item) {
		$_item = $this->app->object->create('cartitem');
        $_item->attributes = $this->app->data->create();
    	foreach($item as $key => $value) {
                switch ($key) {
                    case 'attributes':
                    case 'shipping':
                        $_item->$key = $this->app->data->create($value);
                        break;
                    case 'options':
                        $opt_set = $_item->attributes->get('option-set');
                        if (file_exists($this->app->path->path('classes:data/'.(!is_null($opt_set) ? $opt_set['value'] : 'null').'.php'))) {
                            $_item->options = $this->app->data->create($value, $opt_set['value']);
                            $_item->options->ksort();
                        } else {
                            $_item->options = $this->app->data->create($value);
                        }
                        break;
                    case 'price':
                        $_item->$key = floatval($value);
                        break;
                    default:
                        if(is_numeric($value)) {
                            $_item->$key = intval($value);
                        } else {
                            $_item->$key = $value;
                        }    
                }
    	}
    	return $_item;
    }

    public function remove($sku) {
        if ($this->_items->get($sku)) {
            $this->_items->remove($sku);
            return $this->updateSession();
        }
        
        return $this->_items;
    }

    public function getItemCount() {
        $count = 0;
        foreach($this->_items as $item) {
            $count += (int) $item->qty;
        }
        return $count;
    }

    public function getCartTotal() {
        $total = 0.00;
        foreach($this->_items as $item) {
            $total += $item->price*$item->qty;
        }
        return $total;
    }

    public function emptyCart() {
        $this->_items = $this->app->data->create();
        return $this->updateSession();
    }

    public function updateQuantity($sku, $qty) {

        if ($qty == 0) {
            return $this->remove($sku);
        } else {
            $item = $this->get($sku)->qty = $qty;
        }
        
        return $this->updateSession();
    }

    public function updateSession() {
        $this->app->session->set('cart',(string) $this->_items,'checkout');
        return $this;
    }

    public function __toString() {

        $cart = array(
            'itemCount' => $this->getItemCount(),
            'cartTotal' => $this->getCartTotal(),
            'items' => $this->_items
        );
        return (string) $this->app->data->create($cart);
    }
    
}