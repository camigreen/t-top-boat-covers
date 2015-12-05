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
class ElementUserOptions extends ElementStore {
    

        public function __construct() {
            parent::__construct();
        }
	/*
	   Function: edit
	       Renders the edit form field.

	   Returns:
	       String - html
	*/
	public function edit($params = array()) {
            $vals = $this->get('select');
            $array = $this->getControlName('select');
            $element_id = $this->identifier;
            $options = array();
            $select = array();
            if (empty($vals)) {
                $select[0]['label_value'] = '';
                $select[0]['label_field'] = $array."[0][label]";;
                $select[0]['name_field'] = $array."[0][name]";
                $select[0]['name_value'] = '';
                $select[0]['default_field'] = $array."[0][default]";
                $select[0]['default_value'] = "";
                $select[0]['field_field'] = $array."[0][field]";
                $select[0]['field_value'] = "";
                $select[0]['choices'] = $this->editoption($array."[0][choices]",0);
                return $this->renderLayout($this->app->path->path("elements:useroptions/options.php"), compact('select', 'element_id'));
            }

            foreach($vals as $k => $v) {
                $select[$k]['label_field'] = $array."[$k][label]";
                $select[$k]['label_value'] = isset($v['label']) ? $v['label'] : $v['name'];
                $select[$k]['name_field'] = $array."[$k][name]";
                $select[$k]['name_value'] = $v['name'];
                $select[$k]['default_field'] = $array."[$k][default]";
                $select[$k]['default_value'] = $v['default'];
                $select[$k]['field_field'] = $array."[$k][field]";
                $select[$k]['field_value'] = $v['field'];
                foreach($v['choices'] as $key => $value) {
                    $options[] = $this->editoption($array."[{$k}][choices]", $key, $value['name'], $value['value']);
                }
                $select[$k]['choices'] = implode('',$options);
                $options = array();
                
            }
            return $this->renderLayout($this->app->path->path("elements:useroptions/options.php"), compact('select', 'element_id'));
            
	}
        
        public function editoption ($var, $num, $name = null, $value = null) {
            return $this->renderLayout($this->app->path->path("elements:useroptions/tmpl/editoption.php"), compact('var', 'num', 'name', 'value'));
        }
        
        public function render($params = array()) {
            $select = $this->get('select');
            foreach ($select as $k => $s) {
                $select[$k]['field'] = strtolower(str_replace(' ','_',$s['field']));
                $options = array();
                if ($s['default'] == '') {
                    $options[] = array(                        
                        'name' => '- Select -',
                        'value' => 'X',
                        'selected' => true
                    );
                    
                }
                foreach($s['choices'] as $key => $choice) {
                    $options[] = array(                        
                        'name' => $choice['name'],
                        'value' => $choice['value'],
                        'selected' => $s['default'] == $choice['value'] ? true : false
                    );
                }
                $select[$k]['choices'] = $options;
            }
            
            return $this->renderLayout($this->app->path->path("elements:useroptions/tmpl/rendered.php"), compact('select','params'));
            
           
        }
        
        public function hasValue($params = array()) {
            $select = $this->get('select');
            $result = true;
            foreach($select as $s) {
                if ($s['name'] == '' || $s['field'] == '') {
                    $result = false;
                }
            }
            return $result;
        }
        
        public function loadAssets() {
		$this->app->document->addScript('elements:useroptions/options.js');
		$this->app->document->addStylesheet('elements:useroptions/option.css');
		return parent::loadAssets();
	}
        

}