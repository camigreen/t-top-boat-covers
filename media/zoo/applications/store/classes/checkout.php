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
class Checkout {
    
    protected $_items = array();
    
    public $tax_rate = .07;
    
    protected $merchant;
    
    public $app;
    
    public function __construct($app) {
        $this->app = $app;
    }
    
    public function register($items) {
        $items = (array) $items;
        
        foreach($items as $key => $value) {
            $item = json_decode($value);
            $desc = array();
            foreach($item->options as $option) {
                $desc[] = $option->name.': '.$option->text;
            }
            $this->_items[$key] = array(
                'name' => $item->name,
                'description' => $desc,
                'qty' => $item->qty,
                'price' => number_format($item->qty*$item->price, 2, '.', ''),
                'price_formatted' => $this->formatCurrency($item->qty*$item->price),
                'shipping' => $item->shipping
            );
            
//            var_dump($this->_items[$key]);
        }

    }
    
    public function getItems() {
        return $this->_items;
    }
    protected function formatCurrency($value) {
        return '$'.number_format($value, 2, '.', '');
    }
    
    public function total($format = true) {
        $subTotal = $this->subTotal(false);
        $shipTotal = $this->shippingTotal(false);
        $tax = $this->taxTotal(false);
        $total = $subTotal+$shipTotal+$tax;
        return ($format ? $this->formatCurrency($total) : $total);
    }
    
    public function subTotal($format = true) {
        $subTotal = 0;
        foreach($this->_items as $item) {
            $subTotal += $item['price'];
        }
        return ($format ? $this->formatCurrency($subTotal) : $subTotal);
    }
    
    public function taxTotal($format = true) {
        $subTotal = $this->subtotal(false);
        $taxes = $subTotal*$this->tax_rate;
        
        return ($format ? $this->formatCurrency($taxes) : $taxes);   
    }
    
    public function shippingTotal($format = true) {
        $shipTotal = 0;
        foreach($this->_items as $item) {
            $shipTotal += $item['shipping'];
        }
        return ($format ? $this->formatCurrency($shipTotal) : $shipTotal);
    }
    
    public function setTaxRate(float $rate) {
        $this->tax_rate = $rate;
    }
    
    public function taxRate() {
        return $this->tax_rate;
    }
    
    public function __get($name) {
        return $this->$name();
    }
}
