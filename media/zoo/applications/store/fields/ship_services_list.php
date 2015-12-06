<?php 
$methods = $this->app->shipper->getAvailableShippingMethods();


printf('<select %s>', $this->app->field->attributes(array('name' => "{$control_name}[{$name}]", 'class' => $class)));
printf('<option %s>%s</option>', 'value=""', '- SELECT -');

foreach ($methods as $method) {

	// set attributes
	$attributes = array('value' => $method->getCode());

	// is checked ?
	if ($method->getCode() == $value) {
		$attributes['selected'] = 'selected';
	}

	printf('<option %s>%s</option>', $this->app->field->attributes($attributes), JText::_($method->getDescription()));
}

printf('</select>');
?>