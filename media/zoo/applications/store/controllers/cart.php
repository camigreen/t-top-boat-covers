<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

/*
    Class: DefaultController
        Site controller class
*/
class CartController extends AppController {

    
    public function __construct($default = array()) {
        parent::__construct($default);

        $this->cart = $this->app->cart;

        // get application
        $this->application = $this->app->zoo->getApplication();

        // get Joomla application
        $this->joomla = $this->app->system->application;

        // get params
        $this->params = $this->joomla->getParams();

        // get pathway
        $this->pathway = $this->joomla->getPathway();

        // set base url
        $this->baseurl = $this->app->link(array('controller' => $this->controller), false);

        // registers tasks
        $this->registerTask('init', 'output');

        $this->account = $this->app->customer->getParent();
    }
    
    /*
            Function: display
                    View method for MVC based architecture

            Returns:
                    Void
    */
    public function add() {

        $items = $this->app->request->get('cartitems','array');

        $this->cart->add($items);
        
        $this->output();

    }

    public function updateQty() {
        $sku = $this->app->request->get('sku','string');
        $qty = $this->app->request->get('qty','int');
        $this->cart->updateQuantity($sku, $qty);
        $this->output();
    }

    public function emptyCart() {
        $this->cart->emptyCart();
        $this->output();
    }

    public function remove() {
        $sku = $this->app->request->get('sku','string');
        $this->cart->remove($sku);
        $this->output();
    }

    public function output() {
        $this->app->document->setMimeEncoding('application/json');
        $items = $this->cart->getAllItems();
        foreach($items as $key => $item) {
            $items[$key] = $item->toSession();
        }
        $result = array(
            'result' => true,
            'items' => $items,
            'item_count' => $this->cart->getItemCount(),
            'total' => $this->cart->getCartTotal()
        );
        echo json_encode($result);
    }

    
}