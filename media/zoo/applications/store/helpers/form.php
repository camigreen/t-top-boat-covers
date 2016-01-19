<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

/**
 * ParmeterForm helper class.
 *
 * @package Component.Helpers
 * @since 2.0
 */
class FormHelper extends AppHelper {

	/**
	 * Creates a parameter form instance
	 *
	 * @param array $args
	 * @return AppParameterForm
	 * @since 2.0
	 */
	public function create($args = array()) {
		$args = (array) $args;
		array_unshift($args, $this->app);
		return $this->app->object->create('AppForm', $args);

	}

	/**
	 * Convert params to AppData
	 *
	 * @param JParameter|AppParameterForm|array $params
	 * @return AppData the converted params
	 * @since 2.0
	 */
	public function convertParams($params = array()) {

		if ($params instanceof AppParameterForm) {
			$params = $params->getValues();
		}

		return $this->app->data->create($params);
	}

}

/**
 * Render parameter XML as HTML form.
 *
 * @package Component.Helpers
 * @since 2.0
 */
class AppForm {

	/**
	 * App instance
	 *
	 * @var App
	 * @since 2.0
	 */
	public $app;

	/**
	 * Array of values
	 *
	 * @var array
	 */
	protected $_values = array();

	/**
	 * The xml params object array, with each group as array key.
	 * @var array
	 */
	protected $_xml;

	/**
	 * Class constructor
	 *
	 * @param App $app The app instance
	 * @param string|SimpleXMLElement $xml The xml file path or the xml string or the SimpleXMLElement
	 * @since 2.0
	 */
	public function __construct($app, $xml = null, $params = array()) {

		// init vars
		$this->app = $app;
		$this->loadXML($xml, $params);
	}

	/**
	 * Retrieve a form value
	 *
	 * @param string $name
	 * @param mixed $default
	 *
	 * @return mixed
	 * @since 2.0
	 */
	public function getValue($name, $default = null) {

		if (isset($this->_values[$name])) {
			return $this->_values[$name];
		}

		return $default;
	}

	/**
	 * Set a form value
	 *
	 * @param string $name
	 * @param mixed $value
	 *
	 * @return self
	 * @since 2.0
	 */
	public function setValue($name, $value) {
		$this->_values[$name] = $value;
		return $this;
	}

	/**
	 * Retrieve form values
	 *
	 * @return array
	 * @since 2.0
	 */
	public function getValues() {
		return $this->_values;
	}

	/**
	 * Set form values
	 *
	 * @param array $values
	 *
	 * @return self
	 * @since 2.0
	 */
	public function setValues($values) {
		if(empty($this->_values)) {
			$this->_values = (array) $values;
		} else {
			foreach((array)$values as $key => $value) {
				$this->_values[$key] = $value;
			}
		}

		
		return $this;
	}

	/**
	 * Add a directory to search for field types
	 *
	 * @param string $path
	 *
	 * @return self
	 * @since 2.0
	 */
	public function addElementPath($path) {
		$this->app->path->register($path, 'fields');
		return $this;
	}

	/**
	 * Return number of params to render
	 *
	 * @param string $group Parameter group
	 *
	 * @return int Parameter count
	 * @since 2.0
	 */
	public function getFieldsCount($group = '_default') {
		if (!isset($this->_xml[$group]) || !count($this->_xml[$group]->children())) {
			return false;
		}

		return count($this->_xml[$group]->children());
	}

	/**
	 * Get the number of params in each group
	 *
	 * @return array Array of all group names as key and parameter count as value
	 * @since 2.0
	 */
	public function getGroups() {
		if (!is_array($this->_xml)) {
			return false;
		}

		$results = array();

		foreach ($this->_xml as $name => $group) {
			$results[$name] = $this->getFieldsCount($name);
		}

		return $results;
	}

	/**
	 * Get the number of params in each group
	 *
	 * @return array Array of all group names as key and parameter count as value
	 * @since 2.0
	 */
	public function checkGroup($group) {
		if (!is_array($this->_xml)) {
			return false;
		}

		$results = $this->getGroups();

		return isset($results[$group]);
	}

	/**
	 * Sets the xml for a group
	 *
	 * @param SimpleXMLElement $xml
	 * @since 2.0
	 */
	public function setXML($xml) {
		if ($xml instanceof SimpleXMLElement) {

			if ($group = (string) $xml->attributes()->group) {
				$this->_xml[$group] = $xml;
			} else {
				$this->_xml['_default'] = $xml;
			}

			if ($path = (string) $xml->attributes()->addpath) {
				$this->addElementPath(JPATH_ROOT.$path);
			}
		}
	}

	/**
	 * Loads an xml file or formatted string and parses it
	 *
	 * @param string|SimpleXMLElement $xml The xml file path or the xml string or an SimpleXMLElement
	 *
	 * @return boolean true on success
	 * @since 2.0
	 */
	public function loadXML($xml, $params = array()) {

		extract($params);

		$element = false;

		if ($xml instanceof SimpleXMLElement) {
			$element = $xml;
		}

		// load xml file or string ?
		if ($element || ($element = @simplexml_load_file($xml)) || ($element = simplexml_load_string($xml))) {

			foreach($element->type as $_type) {
				if($_type->attributes()->name == $type) {
					$element = $_type;
					continue;
				}
			}
			if (isset($element->fieldset)) {
				$this->setValue('class', (string) $element->attributes()->class);
				foreach ($element->fieldset as $fieldset) {
							$this->setXML($fieldset);
					
				}
				return true;
			}
		}



		return false;
	}

	/**
	 * Adds an xml file or formatted string and parses it
	 *
	 * @param string|SimpleXMLElement $xml The xml file path or the xml string or an SimpleXMLElement
	 *
	 * @return boolean true on success
	 * @since 2.0
	 */
	public function addXML($xml) {

		$element = false;

		if ($xml instanceof SimpleXMLElement) {
			$element = $xml;
		}

		// load xml file or string ?
		if ($element or $element = @simplexml_load_file($xml) or $element = simplexml_load_string($xml)) {
			if (isset($element->params)) {
				foreach ($element->params as $params) {

					$group = $params->attributes()->group ? (string) $params->attributes()->group : '_default';

					if (!isset($this->_xml[$group])) {
						$this->_xml[$group] = new SimpleXMLElement('<params></params>');
					}

					foreach ($params->param as $param) {
						// Avoid parameters in the same group with the same name
						$existing_params = $this->_xml[$group]->children();
						foreach ($existing_params as $existing_param) {
							// If it exists already ( Skip array params, they can have the same name )
							if (((string) $existing_param->attributes()->name == (string) $param->attributes()->name)) {
								// remove the old and let it add the new
								$dom = dom_import_simplexml($existing_param);
								$dom->parentNode->removeChild($dom);
								continue;
							}
						}

						$this->_appendSimpleXMLElement($this->_xml[$group], $param);
					}

					if ($path = (string) $params->attributes()->addpath) {
						$this->addElementPath(JPATH_ROOT.$path);
					}
				}

				return true;
			}
		}

		return false;
	}

	/**
	 * Get the xml for a specific group or all groups
	 *
	 * @param string $group
	 * @return SimpleXMLElement|array|false Array of groups or the xml for a group
	 * @since 2.0
	 */
	public function getXML($group = null) {

		if (!$group) {
			return $this->_xml;
		}

		if (isset($this->_xml[$group])) {
			return $this->_xml[$group];
		}

		return false;
	}

	/**
	 * Render parameter HTML form
	 *
	 * @param string $control_name The name of the control, or the default text area if a setup file is not found
	 * @param string $group Parameter group
	 *
	 * @return string HTML output
	 * @since 2.0
	 */
	public function render($group = '_default', $control_name = 'core') {
		$groups = is_array($group) ? $group : (array) $group;
		foreach($groups as $group) {

			
			if (!isset($this->_xml[$group])) {
				return false;
			}
			$html[] = '';
			
			
			$adminOnly = (bool) $this->_xml[$group]->attributes()->admin;
			if($adminOnly && (!$this->app->customer->isStoreAdmin())) {
				continue;
			}

			$html[] = '<fieldset id="'.$group.'">';
			if((string)$this->_xml[$group]->attributes()->label) {
				$html[] = '<legend>'.JText::_((string)$this->_xml[$group]->attributes()->label).'</legend>';
			}
			$html[] = '<ul class="uk-grid parameter-form">';

			$group_control_name = $this->_xml[$group]->attributes()->controlname ? $this->_xml[$group]->attributes()->controlname : $control_name;

			// add params
			foreach ($this->_xml[$group]->field as $field) {
				$adminOnly = (bool) $field->attributes()->admin;
				if($adminOnly && (!$this->app->customer->isStoreAdmin())) {
					continue;
				}
				// init vars
				$type = (string) $field->attributes()->type;
				$name = (string) $field->attributes()->name;
				$width = (string) $field->attributes()->width;
				$required = (bool) $field->attributes()->required;
				$width = $width ? $width : '1-1';
				$default = strlen((string) $field->attributes()->default) > 0 ? (string) $field->attributes()->default : null; 
				$value = $this->getValue($name, $default);
				$class = 'uk-width-1-1' . ($required ? ' required' : '');
				$control_name = $field->attributes()->controlname ? $field->attributes()->controlname : $group_control_name;
				
				$_field = '<div class="field">'.$this->app->field->render($type, $name, $value, $field, array('control_name' => $control_name, 'parent' => $this, 'class' => $class)).'</div>';
				
				if ($type != 'hidden') {
					$html[] = '<li id="'.$group.'-'.$name.'" class="parameter uk-width-'.$width.'">';

					$output = '&#160;';
					if ((string) $field->attributes()->label != '') {
						$attributes = array('for' => $control_name.$name);
						if ((string) $field->attributes()->description != '') {
							$attributes['class'] = 'hasTip';
							$attributes['title'] = JText::_($field->attributes()->label).'::'.JText::_($field->attributes()->description);
						}
						$output = sprintf('<label %s>%s</label>', JText::_($this->app->field->attributes($attributes)), JText::_($field->attributes()->label));
					}

					$html[] = "<div class=\"label\">$output</div>";
					$html[] = $_field;
					$html[] = '</li>';
				} else {
					$html[] = $_field;
				}
			}

			$html[] = '</ul>';
		}

		return implode("\n", $html);
	}

	protected function _appendSimpleXMLElement($parent, $child) {
		if (strlen(trim((string) $child)) == 0) {
			$xml = $parent->addChild($child->getName());
			foreach ($child->children() as $child_xml) {
				$this->_appendSimpleXMLElement($xml, $child_xml);
			}
		} else {
			$xml = $parent->addChild($child->getName(), (string) $child);
		}
		foreach ($child->attributes() as $n => $v) {
			$xml->addAttribute($n, $v);
		}
	}

}