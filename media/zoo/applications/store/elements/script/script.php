<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

App::getInstance('zoo')->loader->register('ElementRepeatable', 'elements:repeatable/repeatable.php');


/*
	Class: ElementSelect
		The select element class
*/
class ElementScript extends Element {
    

	/*
	   Function: edit
	       Renders the edit form field.

	   Returns:
	       String - html
	*/
	public function edit($params = array()) {
            
            $value = $this->get('value', $this->config->get('default'));
            return $this->app->html->_('control.textarea', $this->getControlName('value'), $value);
	}
        
        public function render($params = array()) {
            $value = $this->get('value');
            
            return '<script>'.$value.'</script>';
        }
        
        public function hasValue($params = array()) {
            if($this->get('value')) {
                return true;
            }
            return false;
            
        }
        
        

}