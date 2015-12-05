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
class ElementCart extends ElementStore {
    
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
	public function edit()
        {
            
	}
        
        public function render($params = array())
        {
            $engine = $this->config->get('engine');
            
            return $this->renderLayout($this->app->path->path("elements:cart/tmpl/default.php"),compact('engine','params'));
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