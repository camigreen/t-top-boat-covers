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
	public $resource = 'store.lib:/price/list.php';

	// Protected Variables

	/**
	 * The retail price of the item.
	 *
	 * @var [float]
	 * @since 1.0.0
	 */
	protected $_retail;
	
	/**
	 * The discount price of the item.
	 *
	 * @var [float]
	 * @since 1.0.0
	 */
	protected $_discount;

	/**
	 * The markup price of the item.
	 *
	 * @var [datatype]
	 * @since 1.0.0
	 */
	protected $_markup;

	/**
	 * Price List for the provided group
	 *
	 * @var [ParameterData]
	 * @since 1.0.0
	 */
	protected $_priceList;

	/**
	 * @var [string]
	 */
	protected $_group;

	/**
	 * @var [float]
	 */
	protected $_base;

	/**
	 * @var [float]
	 */
	protected $_discountRate = 0;

	/**
	 * @var [float]
	 */
	protected $_markupRate = 0;

	/**
	 * @var [array]
	 */
	protected $_price_options;

	/**
	 * Item Object
	 *
	 * @var [StoreItem]
	 * @since 1.0.0
	 */
	public $_item;
	
	
	/*
	* Class Constructor
	*/
	public function __construct($app, StoreItem $item, $resource = null) {
		$this->app = $app;
		$this->setItem($item);
		$this->init();
		
	}
	public function get($name = 'retail', $formatted = false) {
		if(!$this->{'_'.$name}) {
			$this->calculate();
		}
		if ($formatted) {
			$price = $this->app->number->currency($this->$name(), array('currency' => 'USD'));
		} else {
			$price = (float) $this->$name();
		}
		return $price;
	}
	protected function discount() {
		return (float) $this->_discount;
	}
	protected function markup() {
		return (float) $this->_markup;
	}
	protected function retail() {
		return (float) $this->_retail;
	}
	protected function init() {


		// Set the Markup
		$account = $this->app->customer->getAccount();
		$this->setMarkupRate($account->params->get('markup')/100);

		// Set the Discount
		$this->setDiscountRate($account->params->get('discount')/100);


		return $this;
	}

	/**
	 * Describe the Function
	 *
	 * @param 	datatype		Description of the parameter.
	 *
	 * @return 	datatype	Description of the value returned.
	 *
	 * @since 1.0
	 */
	protected function calculate() {
		if($path = $this->app->path->path($this->resource)) {
			include $path;
		}
		$prices = $this->app->parameter->create($price);
		$this->_price_options = $this->app->parameter->create($prices->get($this->_group.'.item.option.'));
		$this->_base = $prices->get($this->_group.'.item.base');
		$options = $this->getCalculatedOptions();
		$this->_retail = $this->_base + $options;
		$this->_markup = $this->_retail + ($this->_retail*$this->_markupRate);
		$this->_discount = $this->_retail - ($this->_retail*$this->_discountRate);
	}
	/**
	 * Describe the Function
	 *
	 * @param 	datatype		Description of the parameter.
	 *
	 * @return 	datatype	Description of the value returned.
	 *
	 * @since 1.0
	 */
	public function getCalculatedOptions() {
		$total = 0;
		foreach($this->getItemOptions() as $key => $value) {
			$total += $this->_price_options->get($key.'.'.$value->get('value'), 0);
		}
		return $total;		
	}
	public function setGroup($value = null) {
		$this->_group = $value;
		return $this;
	}
	public function getGroup() {
		return $this->_group;
	}
	public function getDiscountRate() {
		return $this->app->number->toPercentage($this->_discountRate*100, 0);
	}
	public function setDiscountRate($value = 0) {
		$this->_discountRate = (float) $value;
		return $this;
	}
	public function getMarkupRate($format = false) {
		$result = $this->_markupRate;
		if($format) {
			$result = $this->app->number->toPercentage($result*100, 0);
		}
		return $result;
	}
	public function setMarkupRate($value = 0) {
		$this->_markupRate = (float) $value;
		$this->calculate();
		return $this;
	}
	/**
	 * Set the Item
	 *
	 * @param 	StoreItem	$item 	StoreItem Class Object
	 *
	 * @return 	Price 	$this	Support for chaining.
	 *
	 * @since 1.0
	 */
	public function setItem(StoreItem $item) {
		$this->_item = $item;
		$this->setGroup($item->getPriceGroup());
		$this->calculate();
		return $this;
	}

	/**
	 * Get an Item Option
	 *
	 * @param 	string	$key	The option key
	 *
	 * @return 	mixed	The value of the option.
	 *
	 * @since 1.0
	 */
	protected function _getItemOption($key, $default = null) {
		return $this->_item->options->get($key, $default);
	}

	/**
	 * Get all Item Options
	 *
	 * @return 	ParameterData	ArrayObject Class containing all option data.
	 *
	 * @since 1.0
	 */
	public function getItemOptions() {
		return $this->_item->options;
	}
	/**
	 * Describe the Function
	 *
	 * @param 	datatype		Description of the parameter.
	 *
	 * @return 	datatype	Description of the value returned.
	 *
	 * @since 1.0
	 */
	public function getMarkupList() {
        $default = $this->_markupRate;
        $store = $this->app->account->getStoreAccount();
        $markups = $store->params->get('options.markup.');
        $list = array();
        foreach($markups as $value => $text) {
            $price = $this->get('retail');
            $diff = $price * ($value/100);
            $price += $diff;
            $list[] = array('markup' => $value/100, 'price' => $price, 'formatted' => $this->app->number->currency($price, array('currency' => 'USD')), 'text' => $text.($text == 'No Markup' ? ' ' : ' Markup '), 'diff' => $diff,'default' => $default == $value/100 ? true : false);
        }
        //var_dump($list);
        return $list;
    }

    /**
     * Describe the Function
     *
     * @param 	datatype		Description of the parameter.
     *
     * @return 	datatype	Description of the value returned.
     *
     * @since 1.0
     */
    public function __get($name) {
    	return $this->get($name);
    }
}

/**
 * The Exception for the Price class
 *
 * @see Price
 */
class PriceException extends AppException {}

?>