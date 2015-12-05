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
class Product {
    
    /**
     * Unique ID for the product.  This is the ID provided by ZOO.
     *
     * @var string
     **/
    public $id;

     /**
     * Name of the product that is displayed to the user.
     *
     * @var string
     **/
    public $name;

    /**
     * Product Category
     *
     * @var string
     **/
    public $category;

    /**
     * Price of the product
     *
     * @var float
     **/
    public $price;
    
    /**
     * Attributes associated with the product
     * This variable is an array of objects.
     *
     * @var array
     **/
    public $attributes = array();
    
    /**
     * Options associated with the product
     * This variable is an array of objects.
     *
     * @var array
     **/
    public $options array();

    /**
     * Description of the item displayed to the user.
     *
     * @var string
     **/
    public $description;
    
    /**
     * Unique ID that identifies this object once all of the options and attributes have been added.
     * It is created automatically by the getSKU() function.
     *
     * @var string
     **/
    protected $sku;
    
    /**
     * Determines if the product shoule have sales tax added.
     *
     * @var string
     **/
    public $taxable = true;

    /**
     * Application Helper Object
     *
     * @var object
     **/
    public $app;
    

    public function __construct($app, $item) {
        $this->app = $app;

        $this->_initObject($item);
        
    }

    /**
     * Initialize the Product Class Variables
     *
     * @return void
     * @author 
     **/
    public function _initObject($item)
    {
        foreach ($item as $key => $value) {
            $this->$key = $value;
        }

        $this->sku = $this->getSKU();
    }

    /**
     * Combines the ID, options, and attributes of a products and generates a MD5 hash to create a unique ID that identifies
     * the product once the options have been selected.
     *
     * @return string
     **/
    public function getSKU()
    {
        foreach($this->options as $option) {
            $options[] = $option['value'];
        }
        foreach ($this->attributes as $attribute) {
            $attributes[] = $attribute['value'];
        }

        return hash('md5', $this->id.implode('',$options).implode('',$attributes));
    }
}
