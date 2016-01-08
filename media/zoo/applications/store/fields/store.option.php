<?php
	$editPermission = (string) $node->attributes()->edit;
	$store = $this->app->account->getStoreAccount();
	$optionset = $node->attributes()->optionset;
	$options = $store->params->get('options.'.$optionset.'.');
	$class = $parent->getValue('class');
	$isParent = (bool) $parent->getValue('parent', false);
	var_dump($parent)


	$edit = $this->app->customer->canEdit('account','com_zoo', $id);

	$name = "{$control_name}[$name]";
	$html[] = '<select class="'.$class.'" name="'.$name.'" >';
	foreach($options as $key => $text) {
		$selected = $key == $value ? "selected" : "";
		$html[] = '<option value="'.$key.'" '.$selected.'>'.$text.'</option>';
	}
	$html[] = '</select>';

	echo implode("\n",$html);
?>