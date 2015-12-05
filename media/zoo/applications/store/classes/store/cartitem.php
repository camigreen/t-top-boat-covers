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
class CartItem extends Store{
    
    public $id;
    
    public $name;
    
    public $qty;
    
    public $price;
    
    public $total = 0;
    
    public $shipping;
    
    public $options;
    
    public $attributes = array();
    
    public $description;
    
    public $make;
    
    public $model;
    
    public $pricepoints = array();
    
    public $sku;
    
    public $taxable = true;
    
    public $app;
    
    public function __construct($item, $app) {
        $this->app = $app;
        $item->options = $app->data->create($item->options);
        $item->shipping = $app->data->create($item->shipping);
        foreach ($item as $key => $value) {
            $this->$key = $value;
            
        }
        $this->generateSKU();
        
    }

    
    public function getDescription($type) {
        $lines = array();
        if ($type == 'receipt') {
            foreach($this->options as $option) {
                if (!isset($option['visible']) || $option['visible']) {
                    $lines[] = $option['name'].': '.$option['text'];
                }
            } 
            
        } else {
            foreach($this->options as $option) {
                $lines[] = $option['name'].': '.$option['text'];
            } 
        }
        $html = isset($lines) ? '<p>'.implode('</p><p>', $lines).'</p>' : '';
        return $html;
    }
    public function generateSKU() {
        $options = '';
        foreach($this->options as $key => $value) {
            $options .= $key.$value['text'];
        }
        
        $this->sku = hash('md5', $this->id.$options);
        return $this->sku;
    }
    
    public function get($resource, $formatCurrency = false) {
        
        return ($formatCurrency ? $this->formatCurrency(parent::get($resource)) : parent::get($resource));
    }
 
}
