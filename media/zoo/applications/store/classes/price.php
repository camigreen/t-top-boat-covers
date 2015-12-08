<?php

/**
* 
*/
class Price 
{
	// Public Variables

	/**
	 * @var [string]
	 */
	public $resource = 'prices:prices.php';
	

	// Protected Variables

	/**
	 * @var [string]
	 */
	protected $_item;

	/**
	 * @var [float]
	 */
	protected $_base;
	
	/**
	 * @var [Parameter Data]
	 */
	protected $_prices;

	/**
	 * @var [float]
	 */
	protected $_discount = 0;

	/**
	 * @var [float]
	 */
	protected $_markup = 0;

	/**
	 * @var [array]
	 */
	protected $_options = array();
	
	
	/*
	* Class Constructor
	*/
	public function __construct($app, $resource = null) {
		$this->app = $app;
	}
	public function get() {
		
	}
	public function discount() {
		
	}
	public function markup() {
		
	}
	public function retail() {
		
	}
	public function setItem($value = null) {
		$this->_item = $value;
		return $this;
	}
	public function getItem() {
		return $this->_item;
	}
	public function getDiscountRate() {
		return $this->_discount;
	}
	public function setDiscountRate($value = 0) {
		$this->_markup = $value;
		return $this;
	}
	public function getMarkupRate() {
		return $this->_markup;
	}
	public function setMarkupRate($value = 0) {
		$this->_markup = (float) $value;
		return $this;
	}
	public function setOption($key, $value = null) {
		$this->_options->set($key, $value);
		return $this;
	}
	public function getOption($key, $default = null) {
		return $this->_options->get($key, $default);
	}
	public function setOptions($values = array()) {
		$this->_options = $this->app->parameter->create($values);
		return $this;
	}
	public function getOptions() {
		return $this->_options;
	}
}

/**
 * The Exception for the Price class
 *
 * @see Price
 */
class PriceException extends AppException {}

?>