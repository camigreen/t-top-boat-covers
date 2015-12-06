<?php
	$store = $this->app->account->getStoreAccount();
	$optionset = $node->attributes()->optionset;
	$options = $store->params->get('options.'.$optionset.'.');

	$name = "{$control_name}[$name]";
	$html[] = '<select class="'.$class.'" name="'.$name.'" >';
	foreach($options as $key => $text) {
		$selected = $key == $value ? "selected" : "";
		$html[] = '<option value="'.$key.'" '.$selected.'>'.$text.'</option>';
	}
	$html[] = '</select>';

	echo implode("\n",$html);
?>