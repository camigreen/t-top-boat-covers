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
class ElementItemOptions extends ElementStore {
    

        public function __construct() {
            parent::__construct();
        }
	/*
	   Function: edit
	       Renders the edit form field.

	   Returns:
	       String - html
	*/
	public function edit($params = array())
        {

            $function = 'edit_'.$this->config->get('option_type');
            
            $html = $this->$function($params);
            
            return $html;
            
	}
        
        public function render($params = array())
        {
            
            $function = 'render_'.$this->config->get('option_type');
            
            $html = $this->$function($params);
            

//                    $html = JText::_("The option type id is unknown. (".$this->option_type.")");
            return $html;
        }
        
        protected function edit_global_options($params = array()) {
            
            if ($this->config->get('all_options')) {
                return;
            }
            
//            $items = $this->config->get('items');
//            $items = explode(',',$items);
//            $continue = false;
//            foreach ($items as $item) {
//                if ($item == $this->_item->id) {
//                    $continue = true;
//                }
//            }
//            if(!$continue) {
//                return false;
//            }
            
            $option_type = $this->config->get('option_type');
            $option_list = $this->config->get('option_list');
            include 'option_lists.php';
            $name = $this->config->get('name');
            $chosen_opts = $opts[$option_type][$option_list];

            if (isset($chosen_opts)) {
                
                $options = array();

                foreach ($chosen_opts as $key => $value)
                {
                        $options[] = $this->app->html->_('select.option', $key, $value);
                }

                $style = 'multiple="multiple"';
                
                return $this->renderLayout($this->app->path->path("elements:itemoptions/tmpl/edit_global_options.php"), compact('style','tooltip','params', 'options'));
            }

            return JText::_("There are no options to choose from.");
            
        }
        protected function render_global_options($params = array()) {
            
                

                $option_type = $this->config->get('option_type');
                $option_list = $this->config->get('option_list');
                $fName = $this->config->get('field_name');
                $name = $this->config->get('name');

                include 'option_lists.php';
                $options = $opts[$option_type][$option_list];
                if (!$this->config->get('all_options') && $this->get('option')) {
                    $newOptions = array();
                    $selected = $this->get('option');
                    foreach($options as $key => $option) {
                        if(in_array($key, $selected)) {
                            $newOptions[$key] = $option; 
                        }
                    }
                    $options = $newOptions;
                }
                
                
                $default = $this->config->get('default');
                
                if (!$default) {
                    $chosen_opts[] = $this->app->html->_('select.option', 'X', '-' . JText::_('Select') . '-');
                }
                
                foreach ($options as $key => $value)
                {
                    $chosen_opts[] = $this->app->html->_('select.option', $key, $value);
                }
                $required = ($params['required'] ? 'required' : '');
                $attr = 'class="uk-width-1-1 item-option '.$required.'" data-name="'.$name.'" ';
                switch ($this->config->get('layout')) {
                    case 'dropdown':
                        $html = $this->app->html->_('select.genericlist', $chosen_opts, $fName, $attr, 'value', 'text',$default);
                        break;
                    case 'checkbox':
                        $html = $this->renderLayout($this->app->path->path('elements:itemoptions/tmpl/checkbox.php'), compact('fName','options','params'));
                        break;
                    default:
                        $html = '<p>No option layout chosen.</p>';
                }
                return $html;
            
            
        }
        protected function edit_user_options($params) {
            return $this->renderLayout($this->app->path->path("elements:itemoptions/tmpl/edit_user_options.php"), compact('style', 'options', 'rows', 'cols','tooltip','params'));
        }
        protected function renderUserOptions($params) {
            $name = $this->config->get('name');
            $default = $this->config->get('default');
            $fName = $this->config->get('field_name');
            
            $options[] = $this->app->html->_('select.option', 'X', '-' . JText::_('Select') . '-');
            
            foreach($this as $self) {
                $options[] = $this->app->html->_('select.option', $this->get('value'), $this->get('name'));
            }
            $style = 'class="uk-width-1-1"';
            
            $html = $this->app->html->_('select.genericlist', $options, ($fName == '' ? str_replace(' ','_',strtolower($name)) : str_replace(' ','_',strtolower($fName))), $style, 'value', 'text',$default);
//            $layout = $this->renderLayout($this->app->path->path("elements:itemoptions/tmpl/user_options.php"), compact('params','content'));
            return $html;
        }
        
        protected function edit_user_entered($params) {
            
        }
        
        protected function render_user_entered($params) {
            $fName = str_replace(' ','_',strtolower($this->config->get('name')));
            $placeholder = $this->config->get('default');
            $name = $this->config->get('name');
            $required = ($params['required'] ? 'required' : '');
            return $this->app->html->_('control.text', $fName, $this->get('value'), 'class="uk-width-1-1 item-option '.$required.'" size="60" maxlength="255" placeholder="'.$placeholder.'" data-name="'.$name.'"');
        }
        
        protected function edit_option_checkbox() {
            
        }
        
        protected function render_option_checkbox() {
            
        }
        
        protected function edit_attributes() {
            $option_type = $this->config->get('option_type');
            $option_list = $this->config->get('option_list');
            $default = $this->config->get('default');
            include 'option_lists.php';
            $multiple = $this->config->get('multiple');
            $name = $this->config->get('name');
            
            switch($option_list) {
                case 'boat_length';
                    $chosen_opts = $this->buildBoatLengths($opts['attributes']['boat_length']);
                    break;
                default:
                    $chosen_opts = $opts[$option_type][$option_list];
            }
            
            if (!$default) {
                    $options[] = $this->app->html->_('select.option', '0', '-' . JText::_('Select') . '-');
                }

            if (isset($chosen_opts)) {
                
                $options = array();

                foreach ($chosen_opts as $key => $value)
                {
                        $options[] = $this->app->html->_('select.option', $key, $value);
                }

                $style = $multiple ? 'multiple="multiple" size="5"' : '';

                return $this->app->html->_('select.genericlist', $options, $this->getControlName('option'), $style, 'value', 'text',$this->get('option',$default));
            }

            return JText::_("There are no options to choose from.");
        }
        
        protected function render_attributes() {
            $option_list = $this->config->get('option_list');
            $fName = str_replace(' ','_',strtolower($option_list));
            $name = $this->config->get('name');
            $html = '<input type="hidden" id="'.$fName.'" class="uk-width-1-1" name="'.$fName.'" data-name="'.$name.'" value="'.$this->get('option').'" />';
            return $html;
        }
        
        protected function edit_item_year () {
            
            $option_type = $this->config->get('option_type');
            $option_list = $this->config->get('option_list');
            $multiple = $this->config->get('multiple');
            $name = $this->config->get('name');
            $tooltip = $this->config->get('tooltip');


            return $this->renderLayout($this->app->path->path("elements:itemoptions/tmpl/edit_item_year.php"), compact('params'));
            
        }
        
        protected function render_item_year ($params) {
            $fName = str_replace(' ','_',strtolower($this->config->get('name')));
            $range = $this->getYearRange($this->get('start'),$this->get('end'));
            $name = $this->config->get('name');
                
            $options[] = $this->app->html->_('select.option', 'X', '-' . JText::_('Select') . '-');

            foreach ($range as $key => $value)
            {
                $options[] = $this->app->html->_('select.option', $key, $value);
            }
            $required = ($params['required'] ? 'required' : '');
            $style = 'class="uk-width-1-1 item-option '.$required.'" data-name="'.$name.'"';

            $html = $this->app->html->_('select.genericlist', $options, $fName, $style, 'value', 'text');

            return $html;
        }
        
        protected function getYearRange($start,$end = NULL) {
            $start = intval($start);
            $end = intval($end);
            if (intval(date('m')) > 5 && $end == 0) {
                $end = date('Y') + 1; 
            } elseif($end == 0) {
                $end = date('Y');
            } else {
                $end = intval($end);
            }
            
            $diff = $end - $start;
            
            $range[$end] = $end;
            for ($i = $diff;$i>=0;$i--) {
                $year = $start + $i;
                $range[$year] = $year;
                
            }
            return $range;
        }
        
        protected function validateYearRange($start,$end) {
            if ($start > date('Y')) {
                return false;
            }
            if ($end != NULL and $end < $start) {
                return false;
            }
            
            return true;
        }
        
        protected function buildBoatLengths($values) {
           foreach($values as $value) {
               $parts = explode('|',$value);
               if (count($parts) == 1) {
                   $arr[$parts[0]] = $parts[0]."'";
               } else {
                   $arr[$parts[0].$parts[1]] = $parts[0]."' to ".$parts[1]."'";
               }
               
           }
           return $arr;
        }
        
        public function hasValue($params = array()) {
            switch ($this->config->get('option_type')) {
                case 'global_options':
                    return true;
                case 'user_options':
                    return true;
                case 'attributes':
                    return true;
                case 'item_year':
                    return $this->validateYearRange(intval($this->get('start')), intval($this->get('end')));
                case 'user_entered':
                    return true;
                case 'option_checkbox';
                    return true;
                default:
                    return false;
            }
            return false;
        }
        
        /*
	   Function: editOption
	      Renders elements options for form input.

	   Parameters:
	      $var - form var name
	      $num - option order number

	   Returns:
		  Array
	*/
	public function editOption($var, $num, $name = null, $value = null){
		return $this->renderLayout($this->app->path->path("elements:itemoptions/tmpl/editoptions.php"), compact('var', 'num', 'name', 'value'));
	}

	/*
		Function: getConfigForm
			Get parameter form object to render input form.

		Returns:
			Parameter Object
	*/
	public function getConfigForm() {
		return parent::getConfigForm()->addElementPath(dirname(__FILE__));
	}
        
        /*
		Function: loadAssets
			Load elements css/js config assets.

		Returns:
			Void
	*/
	public function loadConfigAssets() {
		$this->app->document->addScript('applications:store/elements/itemoptions/option.js');
		$this->app->document->addStylesheet('applications:store/elements/itemoptions/option.css');
		return parent::loadConfigAssets();
	}
        

}