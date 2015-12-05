<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');


/*
	Class: ElementSelect
		The select element class
*/
class ElementPrice extends ElementStore {
    
        public function __construct() {
            parent::__construct();
            $this->app->path->register(dirname(__FILE__).'/assets/', 'assets');
        }

	/*
	   Function: edit
	       Renders the edit form field.

	   Returns:
	       String - html
	*/
	public function edit() {
                return false;
	}
        
        public function render($params = array())
        {
            $price_schedule = 'retail';
            if(!$this->config->get('price_type') || $this->config->get('price_type') == '') {
                $type = $this->_item->alias;
            } else {
                $type = $this->config->get('price_type');
            }
            return $this->renderLayout($this->app->path->path("elements:price/tmpl/default.php"),compact('price_schedule','type'));
        }
        
        public function hasValue($params = array())
        {
            return true;
        }

        public function loadAssets() {
            parent::loadAssets();
            $this->app->document->addScript('elements:cart/assets/js/shop.js');
        }
}