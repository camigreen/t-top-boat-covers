<?php
	$disabled = (bool) $node->attributes()->disabled ? 'disabled' : '';
	$oems = $this->app->table->account->find('all', array('conditions' => array('type = "oem" AND state = 1')));
	var_dump($value);
	foreach($oems as $oem) {
		$options[$oem->id] = $oem->name;
	}
	$name = $control_name.'['.$name.'][]';
	$oem_select = $this->app->html->_('select.genericlist', $options, $name,'class="oem-select uk-width-1-1" multiple="multiple" '.$disabled, 'value', 'text',$value, uniqid('oemlist-'));

?>
	<?php echo $oem_select; ?>

