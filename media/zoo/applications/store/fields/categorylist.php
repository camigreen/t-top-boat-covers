<?php

	//init vars
	$multiselect = $node->attributes()->multiple == 1 ? true : false;

    $options = array();
    if (!$multiselect) {
        $options[] = $this->app->html->_('select.option', '', '-' . JText::_('Select Category') . '-');
    }

	$attribs = ($multiselect) ? 'size="5" multiple="multiple"' : '';

	echo $this->app->html->_('zoo.categorylist', $this->app->zoo->getApplication(), $options, $control_name.'['.$name.']', $attribs, 'value', 'text', $value);

?>