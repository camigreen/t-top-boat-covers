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
class ElementButton extends ElementStore {
    
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
            return $this->app->html->_('control.text', $this->getControlName('value'), $this->get('value', $this->config->get('default')), 'size="60" maxlength="255"');
            
	}
        
        public function render($params = array())
        {       
            return '<a href="'.$this->get('value').'" class="uk-button uk-button-primary">'.$this->config->get('name').'</a>';
        }
        
        public function hasValue($params = array()) {
            return true;
//            if($this->get('value')) {
//                return true;
//            }
//            return false;
            
        }
}