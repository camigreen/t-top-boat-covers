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
     * Contains the ParamterData Class to hold the item parameters.
     *
     * @var [ParameterData]
     * @since 1.0.0
     */
    public $params;
    
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
    protected $price;

        /**
     * String that identifies the pricing group of an item.
     *
     * @var [string]
     * @since 1.0.0
     */
    protected $confirm = false;
    
    
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
    public function __construct($app) {

        $this->app = $app;

        $this->discount = $this->app->customer->getParent()->params->get('discount', 0)/100;

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
        $ignore = array('app', 'params');
        foreach($item as $key => $value) {
            if(property_exists($this, $key)) {
                if(!in_array($key, $ignore)) {
                    $this->$key = $value;
                }
            }
        }
        $options = array();
        $attributes = array();
        $this->params = $this->app->parameter->create();


        if($item instanceof Item) {
            foreach($item->getElementsByType('itemoptions') as $element) {
                if($element->config->get('option_type') == 'global_options') {

                    $value = $element->get('option', $element->config->get('default', null));
                    $key = $element->config->get('field_name');
                    $options[$key] = $this->app->data->create();
                    $options[$key]->set('name', $element->config->get('name'));
                    $options[$key]->set('value', !is_array($value) && $value != '' ? $value : null);
                }
                if($element->config->get('option_type') == 'attributes') {
                    $value = $element->get('option', $element->config->get('default', null));
                    $key = $element->config->get('field_name');
                    $attributes[$key] = $this->app->data->create();
                    $attributes[$key]->set('name', $element->config->get('name'));
                    $attributes[$key]->set('value', !is_array($value) && $value != '' ? $value : null);
                }
            
            }
            foreach($item->getElementsByType('useroptions') as $element) {
                foreach($element->get('select') as $opts) {
                    $options[$opts['field']] = $this->app->data->create();
                    $options[$opts['field']]->set('name', $opts['name']);
                    $options[$opts['field']]->set('value', $opts['default']);
                }
            }
            list($make) = $item->getRelatedCategories();
            $attributes['oem'] = $this->app->data->create();
            $attributes['oem']->set('name', $make->name);
            $attributes['oem']->set('value', $make->id);
            $this->make = $item->getPrimaryCategory()->name;
            $this->price_group = $item->alias;

        } else {
            if(isset($item['options'])) {
                foreach($item['options'] as $key => $option) {
                    $options[$key] = $this->app->data->create();
                    $options[$key]->set('name', $option['name']);
                    $options[$key]->set('value', $option['value']);
                    $options[$key]->set('text', isset($option['text']) ? $option['text'] : null);
                    $options[$key]->set('visible', isset($option['visible']) ? $option['visible'] : true);
                }
            }
            if(isset($item['attributes'])) {
                foreach($item['attributes'] as $key => $attr) {
                    $attributes[$key] = $this->app->data->create();
                    $attributes[$key]->set('name', $attr['name']);
                    $attributes[$key]->set('value', $attr['value']);
                    $attributes[$key]->set('text', isset($attr['text']) ? $attr['text'] : null);
                }
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
                $options .= $option->value;
        }

        // foreach($this->options as $key => $option) {
        //     $parts = explode('.', $key);
        //     var_dump($parts);
        //     $count = count($parts) - 1;
        //     if($parts[$count] == 'value') {
        //         $options .= $parts[$count];
        //     }
        // }
        $options .= $this->getPrice()->getMarkupRate();
        $options .= $this->getPrice()->getDiscountRate();
        $options .= $this->id;
        
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
     * Get the JSON String for the attributes for the item.
     *
     * @return     string    the price group.
     *
     * @since 1.0
     */
    public function getItemsJSON() {
        $item = array();
        // foreach($this->attributes as $key => $value) {
        //     $item[$key] = array(
        //         'value' => $value->get('value'),
        //         'name' => $value->get('name'),
        //         'text' => $value->get('text')
        //         );
        // } 
        $item['id'] = $this->id;
        $item['name'] = $this->name;
        $item['type'] = $this->type;
        $item['model'] = $this->model;
        $item['make'] = $this->make;
        $item['confirm'] = $this->confirm;
        $item['price_group'] = $this->price_group;
        $item['attributes'] = $this->attributes;
        $items[] = $item;    
        return htmlspecialchars(json_encode($items), ENT_QUOTES, 'UTF-8');
        
    }

    public function getOption($name) {
        if(isset($this->options[$name])) {
            return $this->options[$name];
        }
        return $this->app->parameter->create();
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

    public function toSession() {
        $data = $this->app->parameter->create();
        $data->loadObject($this);
        $data->remove('app');
        $data->set('total', $this->getTotal('markup'));
        return $data;
    }

    
}