<?php

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
class TTopBoatCoversItem extends StoreItem {
    
    public function __construct($app, $item) {
        
        parent::__construct($app, $item);
        
    }
    
    public function create($item) {
        
        
        $this->category = $item->getPrimaryCategory();
        $this->id = $item->id;
        $this->make = $this->category->name;
        $this->model = $item->name;
        $this->name = $this->category->getParent()->name.'-'.$this->make.'-'.$this->model;
        $elements = $this->_item->getElements();
        foreach($elements as $element) {
            if ($element->config->get('field_name') == "boat_length") {
                $this->attributes['boat_length'] = $element->get('value');
            }
        }
        $this->description = array(
            'short' => $this->createDescription(),
            'long' => $category->getPrimaryCategory()->getParent()->description
        );
        $this->taxable = true;
        $this->links['make'] = $this->app->route->category($product);
        $this->links['model'] = $this->app->route->category($make);
        $this->options = $this->getOptions($item);
        $this->pricepoints = $this->getPrices('ttopboatcovers');
        $this->sku = $this->generateSKU();
        
        return $this->item;
        
    }

}
