<?php
	$multiple = $node->attributes()->multiple == 1 ? 'multiple' : null;
	$name = $control_name."[$name][]";
	$html[] = '<select name="'.$name.'" class="'.$class.'" '.$multiple.'>';
	if(!$multiple) {
		$html[] = '<option value="0">- Select -</option>';
	}

	$types = (string) $node->attributes()->account_type == "" ? null : (string) $node->attributes()->account_type;
	$types = $types == null ? array() : explode(',', $types);
	$conditions = array();
	foreach($types as $type) {
		$conditions[] = empty($conditions) ? 'type = "'.$type.'"' : ' OR type = "'.$type.'"';
	}
	$condition = implode("\n",$conditions);
	$accounts = $this->app->table->account->all(array('conditions' => $condition));
	$value = (array) $value;
	foreach($accounts as $key => $account) {
		$html[] = '<option value="'.$key.'" '.(array_key_exists($key, $value) ? "selected" : "").' >'.$account->name.'</option>';
	}
	$html[] = '</select>';

	echo implode("\n", $html);

?>