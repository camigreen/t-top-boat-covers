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
     * Item ID
     *
     * @var [int]
     * @since 1.0.0
     */
    public $type;
    
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
     * String that identifies the pricing group of an item.
     *
     * @var [string]
     * @since 1.0.0
     */
    public $markup;

    /**
     * String that identifies the pricing group of an item.
     *
     * @var [string]
     * @since 1.0.0
     */
    public $discount;

    /**
     * String that identifies the pricing group of an item.
     *
     * @var [string]
     * @since 1.0.0
     */
    public $price;
    
    
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
    public function __construct() {

    }

    /**
     * Populate the object with data from the Zoo Item Object
     *
     * @param       Item    Item Object.
     *
     * @return      StoreItem   $this   for chaining support
     *
     * @since 1.0
     */
    public function importItem($item = null) {

        foreach($item as $key => $value) {
            if(property_exists($this, $key)) {
                if($key != 'app') {
                    $this->$key = $value;
                }
            }
        }
        $options = $this->app->parameter->create();
        $attributes = $this->app->parameter->create();


        if($item instanceof Item) {

            foreach($item->getElementsByType('itemoptions') as $element) {
                if($element->config->get('option_type') == 'global_options' || $element->config->get('option_type') == 'user_options') {
                    $value = $element->get('option', $element->config->get('default', null));
                    $key = $element->config->get('field_name');
                    $options->set($key.'.name', $element->config->get('name'));
                    $options->set($key.'.value', !is_array($value) && $value != '' ? $value : null);
                }
                if($element->config->get('option_type') == 'attributes') {
                    $value = $element->get('option', $element->config->get('default', null));
                    $key = $element->config->get('field_name');
                    $attributes->set($key.'.name', $element->config->get('name'));
                    $attributes->set($key.'.value', !is_array($value) && $value != '' ? $value : null);
                }
            
            }
            list($make) = $item->getRelatedCategories();
            $attributes->set('oem.name', $make->name);
            $attributes->set('oem.value', $make->id);
            $this->make = $item->getPrimaryCategory()->name;
            $this->price_group = $item->getType()->id;

        } else {
            var_dump($this->options);
            foreach($item->options as $key => $option) {
                $options->set($key.'.name', $option['name']);
                $options->set($key.'.value', $option['value']);
                $options->set($key.'.text', $option['text']);
            }
            foreach($item->attributes as $key => $attr) {
                $attributes->set($key.'.name', $attr['name']);
                $attributes->set($key.'.value', $attr['value']);
                $attributes->set($key.'.text', $attr['text']);
            }
        }

        $this->options = $options;
        $this->attributes = $attributes;

        

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
        foreach($this->options as $key => $option) {
            $parts = explode('.', $key);
            $count = count($parts) - 1;
            if($parts[$count] == 'value') {
                $options .= $parts[$count];
            }
        }
        $options .= $this->getPrice()->getMarkupRate();
        $options .= $this->getPrice()->getDiscountRate();
        
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
        if(!$this->price) {
            $this->price = $this->app->price->create($this);
        }
        return $this->price;
        
    }

    public function getTotal($display = 'retail', $formatted = false) {
        if(!$this->price) {
            $this->getPrice();
        }
        $total = $this->price->get($display)*$this->qty;
        if($formatted) {
            $total = $this->app->number->currency($total, array('currency' => 'USD'));
        }

        return $total;

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

    /**
     * Describe the Function
     *
     * @param     datatype        Description of the parameter.
     *
     * @return     datatype    Description of the value returned.
     *
     * @since 1.0
     */
    public function getOptionsList() {
        if (count($this->options) > 0) {
            $html[] = "<ul class='uk-list options-list'>";
            foreach($this->options as $option) {
                $html[] = '<li><span class="option-name">'.$option->get('name').':</span><span class="option-text">'.$option->get('text').'</span></li>';
            }
            $html[] = "</ul>";

            return implode('',$html);
        }
    }

    public function export() {
        $data = $this->app->data->create();
        $ignore = array('app', 'price');
        foreach($this as $key => $value) {
            if(!in_array($key, $ignore)) {
                $data->set($key, $value);
            }
            
        }
        $data->set('total', $this->getPrice()->markup);
        return $data;
    }

    public function  __toString() {
        $obj = $this;
        //$obj->options = (string) $obj->options;
        //$obj->attributes = (string) $obj->attributes;
        $obj = $this->app->data->create($obj);
        $obj->remove('price');
        $obj->remove('app');
        return (string) $obj;
    }

    
}