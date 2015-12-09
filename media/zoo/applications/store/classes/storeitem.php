<?php defined('_JEXEC') or die('Restricted access');

/**
 * @package   Package Name
 * @author    Shawn Gibbons http://www.palmettoimages.com
 * @copyright Copyright (C) Shawn Gibbons
 * @license   
 */

/**
 * Class Description
 *
 * @package Class Package
 */
class StoreItem {

    /**
     * Item ID
     *
     * @var [int]
     * @since 1.0.0
     */
    public $id;
    
    /**
     * Item Name
     *
     * @var [string]
     * @since 1.0.0
     */
    public $name;

    /**
     * Item Alias
     *
     * @var [string]
     * @since 1.0.0
     */
    public $alias;
    
    /**
     * Qty of the item.
     *
     * @var [int]
     * @since 1.0.0
     */
    public $qty = 1;
    
    /**
     * Total price of the item.
     *
     * @var [float]
     * @since 1.0.0
     */
    public $total = 0;
    
    /**
     * Reference to the App Object.
     *
     * @var [App]
     * @since 1.0.0
     */
    public $shipping;
    
    /**
     * Array of options and thier values.
     *
     * @var [array]
     * @since 1.0.0
     */
    public $options = array();
    
    /**
     * Array of attributes and thier values
     *
     * @var [array]
     * @since 1.0.0
     */
    public $attributes = array();
    
    /**
     * Description of the item.
     *
     * @var [string]
     * @since 1.0.0
     */
    public $description;
    
    /**
     * Item Make.
     *
     * @var [string]
     * @since 1.0.0
     */
    public $make;
    
    /**
     * Item Model.
     *
     * @var [string]
     * @since 1.0.0
     */
    public $model;
    
    /**
     * String that identifies the pricing group of an item.
     *
     * @var [string]
     * @since 1.0.0
     */
    public $price_group;
    
    /**
     * Item SKU
     *
     * @var [string]
     * @since 1.0.0
     */
    public $sku;
    
    /**
     * Is the item a taxable item
     *
     * @var [bool]
     * @since 1.0.0
     */
    public $taxable = true;

    /**
     * Reference to the App Object.
     *
     * @var [App]
     * @since 1.0.0
     */
    public $app;

    /**
     * Class constructor
     *
     * @param datatype    $app    Parameter Description
     */
    public function __construct($app, $item = null) {
        $this->app = $app;
        if($item instanceof Item) {
            $this->importZooItem($item);
        } else {
            echo 'StoreItem';
        }

        $this->generateSKU();

    }

    /**
     * Populate the object with data from the Zoo Item Object
     *
     * @param       Item    Zoo Item Object.
     *
     * @return      StoreItem   $this   for chaining support
     *
     * @since 1.0
     */
    public function importZooItem(Item $item = null) {

        foreach($item as $key => $value) {
            if(property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        if($item->getType()->id == "t-top-boat-cover") {
            $this->setPriceGroup($item->getType()->id);
        } else {
            $this->setPriceGroup($item->alias);
        }

        foreach($item->getElementsByType('itemoptions') as $element) {
            if($element->config->get('option_type') == 'global_options' || $element->config->get('option_type') == 'user_options') {
                $value = $element->get('option', $element->config->get('default', null));
                $option = $this->app->parameter->create();
                $option->set('field', $element->config->get('field_name'));
                $option->set('name', $element->config->get('name'));
                $option->set('value', !is_array($value) && $value != '' ? $value : null);
                $this->options[$element->config->get('field_name')] = $option;
            }
            if($element->config->get('option_type') == 'attributes') {
                $value = $element->get('option', $element->config->get('default', null));
                $attribute = $this->app->parameter->create();
                $attribute->set('field', $element->config->get('field_name'));
                $attribute->set('name', $element->config->get('name'));
                $attribute->set('value', !is_array($value) && $value != '' ? $value : null);
                $this->attributes[$element->config->get('field_name')] = $attribute;
            }
            
        }

        return $this;
        
    }

    /**
     * Create a unique SKU to identify the Item and the options and attributes selected.
     *
     * @return     datatype    Description of the value returned.
     *
     * @since 1.0
     */
    public function generateSKU() {
        if($this->sku) {
            return $this->sku;
        }
        $options = '';
        foreach($this->options as $key => $value) {
            $options .= $key.$value->get('value');
        }
        //$options .= $this->getPrice();
        
        $this->sku = hash('md5', $this->id.$options);
        return $this->sku;
    }

    /**
     * Describe the Function
     *
     * @param     datatype        Description of the parameter.
     *
     * @return     datatype    Description of the value returned.
     *
     * @since 1.0
     */
    public function getPrice() {
        $this->price = $this->app->price->create($this);
        return $this->price;
        
    }

    /**
     * Get the price group for the item.
     *
     * @return     string    the price group.
     *
     * @since 1.0
     */
    public function getPriceGroup() {
        return $this->price_group;
        
    }

    /**
     * Set the price group.
     *
     * @param   String  $value  The price group.
     *
     * @return  Price   $this   Support for chaining.
     *
     * @since 1.0
     */
    public function setPriceGroup($value) {
        $this->price_group = $value;
        return $this;
    }

    
}