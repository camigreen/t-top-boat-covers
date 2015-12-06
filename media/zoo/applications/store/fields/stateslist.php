<?php 
$states = new SimpleUPS\PostalCodes();


printf('<select %s>', $this->app->field->attributes(array('name' => "{$control_name}[{$name}]", 'class' => $class)));

foreach ($states->getStates('US',true) as $key => $state) {

	// set attributes
	$attributes = array('value' => $key);

	// is checked ?
	if ($key == $value) {
		$attributes['selected'] = 'selected';
	}

	printf('<option %s>%s</option>', $this->app->field->attributes($attributes), JText::_($state));
}

printf('</select>');
?>