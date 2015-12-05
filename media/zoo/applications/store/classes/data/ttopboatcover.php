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
class TtopBoatCoverData extends JSONData {

	protected $order = array('fabric','color','year');


	public function __construct($data = array()) {


		parent::__construct($this->_order($data));

	}

	private function _order ($data) {
		$x = array();
		foreach($data as $key => $value) {

			if(in_array($key, $this->order)) {
				$result[array_search($key, $this->order)] = $value;
			} else {
				$x[$key] = $value;
			}
		}
		foreach($x as $value) {
			$result[] = $value;
		}

		return $result;
	}

	

}