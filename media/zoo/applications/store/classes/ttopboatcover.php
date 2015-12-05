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
class TtopBoatCoverItem extends StoreItem {
    
    public $boat_length;
    
    public function create () {
        
        $make = $this->_item->getPrimaryCategory();
        $product = $make->getParent();
        $model = $this->_item->name;
        $name = $product->name.'-'.$make->name.'-'.$model;
        $elements = $this->_item->getElements();
        foreach($elements as $element) {
            if ($element->config->get('field_name') == "boat_length") {
                $this->item['boat_length'] = $element->get('value');
            }
        }
        $this->item['product_name'] = $product->name;
        $this->item['product_description'] = $product->description;
        $this->item['model'] = $model;
        $this->item['make'] = $make->name;
        $this->item['name'] = $name;
        $this->item['customer_type'] = 'retail';
        $this->item['make_link'] = $this->app->route->category($product);
        $this->item['model_link'] = $this->app->route->category($make);
        $this->item['layout'] = array(
            'name' => 'full'
        );
        $this->item['options'] = $this->getOptions();
        $prices = $this->getPrices();
        return $this->item;
    }
    public function getPrices($name = null) {
        $markup = $this->_item->params->get('content.ship_markup') ? $this->_item->params->get('content.ship_markup') : $this->application->getParams()->get('global.store.ship_markup');
        $path = $this->app->path->path('prices:retail.php');
        include($path);
        if (isset($prices['t-top-boat-cover'])) {
            $prices['t-top-boat-cover']['shipping']['markup'] = (float) str_replace('%','',$markup)/100; 
            return $prices['t-top-boat-cover'];
        }
        return false;
        
    }
    
    
}




//$item['options'] = $fields;
//$item['options']['customer_type'] = 'retail'; 