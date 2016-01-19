<?php
	$editPermission = (string) $node->attributes()->edit;
	$store = $this->app->account->getStoreAccount();
	$optionset = $node->attributes()->optionset;
	$options = $store->params->get('options.'.$optionset.'.');
	$class = $parent->getValue('class');
	$isParent = (bool) $parent->getValue('parent', false);


	$canEdit = $parent->getValue('canEdit');
	$viewOnly = (bool) $node->attributes()->viewOnly;

	if($this->app->customer->isStoreAdmin() || ($canEdit && !$viewOnly)) {
		$name = "{$control_name}[$name]";
		$html[] = '<select class="'.$class.'" name="'.$name.'" >';
		foreach($options as $key => $text) {
			$selected = $key == $value ? "selected" : "";
			$html[] = '<option value="'.$key.'" '.$selected.'>'.$text.'</option>';
		}
		$html[] = '</select>';
	} else {
		$html[] = '<div>'.$options[$value].'</div>';
	}

	echo implode("\n",$html);
?>