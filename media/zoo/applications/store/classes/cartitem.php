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

class CartItem {
    
    public $id;
    
    public $name;
    
    public $qty;
    
    public $price;
    
    public $shipping;

    public $attributes;
    
    public $options;
    
    public $description;
    
    public $taxable = true;

    public $imported = false;

    protected $app;
    
    public function __construct($app, $item = array()) {

        $this->app = $app;
        
        foreach($item as $key => $value) {
            if(property_exists($this, $key) && $key != 'app') {
                $this->$key = $value;
            }
        }
        if(is_string($this->attributes) || is_array($this->attributes) || is_null($this->attributes) || empty($this->attributes)) {
            $this->attributes = $this->app->data->create($this->attributes);
            foreach($this->attributes as $key => $attribute) {
                $attr = $this->app->data->create($attribute);
                $this->attributes->set($key,$attr);
            }
        }
        if(is_string($this->options) || is_array($this->options) || is_null($this->options)) {
            if($opt_set = $this->attributes->get('option-set')) {
                $this->options = $this->app->data->create($this->options, $opt_set->get('value'));
            } else {
                $this->options = $this->app->data->create($this->options);
            }
        }
        if(is_string($this->shipping) || is_array($this->shipping)) {
                $this->shipping = $this->app->data->create($this->shipping);
        }

        $this->price = floatval($this->price);

        return $this;

    }

    public function getSKU() {
        $hash = $this->id;
        if(!is_null($this->options)) {
            foreach($this->options as $key => $option) {
                $hash .= $option['text'];
            }
        }
        if(!is_null($this->attributes)) {
            foreach($this->attributes as $key => $attribute) {
                $hash .= $attribute['value'];
            }
        }
        
        
        return hash('md5', $hash);
    }

    public function getTotal() {
        $total = $this->app->number->currency($this->qty*$this->price,array('currency' => 'USD'));
        return $total;
    }

    public function getOptions() {
        if (count($this->options) > 0) {
            $html[] = "<ul class='uk-list options-list'>";
            foreach($this->options as $option) {
                $html[] = '<li><span class="option-name">'.$option['name'].':</span><span class="option-text">'.$option['text'].'</span></li>';
            }
            $html[] = "</ul>";

            return implode('',$html);
        }
    }

    public function toLog() {
        foreach($this as $key => $value) {
            if($key != 'app') {
                $string[] = $key.': '.$value;
            }
        }
        return implode(PHP_EOL,$string).PHP_EOL.'/////// End of Log ////////'.PHP_EOL;
    }
        
}


