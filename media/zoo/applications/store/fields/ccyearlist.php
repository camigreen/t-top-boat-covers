<?php
	$year = intval(date('Y'));
	$range = 10;
	$result = array();
	for ($i = 0; $i <= $range; $i++ ) {
		$result[$year + $i] = $year + $i;
	}

	$name = "{$control_name}[$name]";
	$html[] = '<select class="'.$class.'" name="'.$name.'" >';
	foreach($result as $key => $year) {
		$selected = $key == $value ? "selected" : "";
		$html[] = '<option value="'.$key.'" '.$selected.'>'.$year.'</option>';
	}
	$html[] = '</select>';

	echo implode("\n",$html);
?>