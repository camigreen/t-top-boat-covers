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
class StoreItem {
    
    protected $_item;
    
    public $item = array();
    
    public $app;
    
    public function __construct($app, $item) {
        $this->app = $app;
        $this->_item = $item;
        $this->item['id'] = $item->id;
        $this->application = $this->app->zoo->getApplication();
        $this->create();
    }
    
    public function getPrices($item = null) {
        $markup = $this->_item->params->get('content.ship_markup') ? $this->_item->params->get('content.ship_markup') : $this->application->getParams()->get('global.store.ship_markup');
        $name = (is_null($item) ? $this->_item->alias : $item);
        $path = $this->app->path->path('prices:retail.php');
        include($path);
        if (isset($prices[$name])) {    
            $prices[$name]['shipping']['markup'] = (float) str_replace('%','',$markup)/100;      
            return $prices[$name];
        }
        return false;
        
    }
    
    protected function create() {
        $this->item['name'] = $this->_item->name;
        $this->item['options'] = $this->getOptions();
        return $this->item;
        
    }
    
    protected function getOptions() {
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
    
    public function getJSON() {
        return json_encode($this->item);
    }
    
}
