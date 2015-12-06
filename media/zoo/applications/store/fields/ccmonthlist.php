
<?php

	$months = array(
			'01' => '01 - Jan',
			'02' => '02 - Feb',
			'03' => '03 - Mar',
			'04' => '04 - Apr',
			'05' => '05 - May',
			'06' => '06 - Jun',
			'07' => '07 - Jul',
			'08' => '08 - Aug',
			'09' => '09 - Sep',
			'10' => '10 - Oct',
			'11' => '11 - Nov',
			'12' => '12 - Dec',
		);
		$name = "{$control_name}[$name]";
		$html[] = '<select class="ttop-checkout-field required uk-width-1-1" name="'.$name.'" >';
		foreach($months as $key => $month) {
			$selected = $value == $key ? "selected" : "";
			$html[] = '<option value="'.$key.'" '.$selected.'>'.$month.'</option>';
		}
		$html[] = '</select>';

		echo implode("\n",$html);
?>