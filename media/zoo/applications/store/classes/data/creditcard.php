<?php defined('_JEXEC') or die('Restricted access');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author Shawn
 */
class CreditCardData extends JSONData {

	protected $cardNumber;
	protected $expMonth;
	protected $expYear;
	protected $card_code;
	protected $card_type;
	protected $card_name;
	protected $auth_code;
	protected $response;
	protected $approved;
	protected $declined;


	public function maskCardNumber($default = null) {
		$cc = parent::get('cardNumber');
		$len = strlen($cc)-4;
		if ($len > 0) {
			return str_repeat('X',$len).substr($cc,-4);
		}
		return $default;
	}

	public function getYearDropDown() {
		$year = intval(date('Y'));
		$range = 10;
		$result = array();
		for ($i = 0; $i <= $range; $i++ ) {
			$result[$year + $i] = $year + $i;
		}

		$html[] = '<select class="ttop-checkout-field required uk-width-1-1" name="payment[creditCard][expYear]" >';
		foreach($result as $key => $value) {
			$selected = ($key == $this->get("expYear")) ? "selected" : "";
			$html[] = '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
		}
		$html[] = '</select>';

		return implode('',$html);

	}

	public function getMonthDropDown() {
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
		$html[] = '<select class="ttop-checkout-field required uk-width-1-1" name="payment[creditCard][expMonth]" value="'.$this->get("expMonth").'" >';
		foreach($months as $key => $value) {
			$selected = ($key == $this->get("expMonth")) ? "selected" : "";
			$html[] = '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
		}
		$html[] = '</select>';

		return implode('',$html);
	}

	public function getExpDate() {
		return $this->get("expMonth").'/'.$this->get("expYear");
	}
}