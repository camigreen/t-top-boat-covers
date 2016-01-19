<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
// init vars
$name = $control_name.'['.$name.'][]';
$attr  = '';
$attr .= (string) $node->attributes()->class ? 'class="'.$node->attributes()->class.'"' : 'class="inputbox"';
$attr .= ((string) $node->attributes()->disabled == 'true') ? ' disabled="disabled"' : '';
$attr .= (string) $node->attributes()->size ? ' size="'.(int) $node->attributes()->size.'"' : '';
$attr .= ((string) $node->attributes()->multiple == 'true') ? ' multiple="multiple"' : '';
$attr .= "name=\"$name\"";

// Initialize JavaScript field attributes.
$attr .= (string) $node->attributes()->onchange ? ' onchange="'.(string) $node->attributes()->onchange.'"' : '';

//echo $this->app->html->_('usergrouplist', array(), $control_name.'['.$name.']', $attr, 'value', 'text', $value, $control_name.$name);
$options = JHtmlUser::groups();
//var_dump($options);
if(!$parent->getValue('id')) {
	$value = (string) $node->attributes()->default;
}
if(is_string($value)) {
	$value = explode(',', $value);
}

printf('<select %s>', $attr);

foreach ($options as $option) {
	$attributes = array();
	$attributes['value'] = $option->value;
	// is checked ?
	if (in_array($option->value, $value)) {
		$attributes['selected'] = 'selected';
	}

	printf('<option %s>%s</option>', $this->app->field->attributes($attributes), JText::_($option->text));
}

printf('</select>');