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
class StoreItem extends Store {
    
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
    
    public $product_category;
    
    public $pricepoints = array();
    
    public $sku;
    
    public $taxable = true;
    
    protected $links = array();
    
    public $app;
    
    protected $category;
    
    public function __construct($app, $item) {
        $this->app = $app;
        $this->create($item);
        
    }
    
    public function create($item) {
        return $item;
    }
    
    protected function createDescription() {
        $this->description = '';
            foreach($this->options as $option) {
                $this->description .= '<p>'.$option->name.': '.$option->text.'</p>';
        }
    }
    public function generateSKU() {
        $options = '';
        foreach($this->get('options') as $key => $value) {
            $options .= $key.$value->value;
        }
        return hash('md5', $this->id.$options);
    }
    
    protected function getOptions($items) {
        $fields = array();
        foreach ($this->_item->getElementsByType('itemoptions') as $options)  {
            if (property_exists($this, $options->config->get('field_name'))) {
                $this->item[$options->config->get('field_name')] = $options->get('option');
            } else {
                $fields[$options->config->get('field_name')] = array('name' => $options->config->get('name'), 'value' => null);
            }
    
        }
        return $fields;
    }
    
    public function getPrices($item, $format = 'json') {
        $path = $this->app->path->path('prices:retail.php');
        include($path);
        $this->shipping = '{}';
        if (isset($prices[$item]['item'])) {
            $this->pricepoints = $this->app->data->create($prices[$item]['item']);
        }
        if (isset($prices[$item]['shipping'])) {
            $this->shipping = $prices[$item]['shipping'][$this->attributes['boat_length']];
        }
        
        return '{}';
    }
    public function get($resource, $formatCurrency = false) {
        
        return ($formatCurrency ? $this->formatCurrency(parent::get($resource)) : parent::get($resource));
    }
 
}

