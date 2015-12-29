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
	 * The shipping weight of the item.
	 *
	 * @var [float]
	 * @since 1.0.0
	 */
	protected $_shipWeight;

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
		// Set the Markup
		$account = $this->app->customer->getParent();
		$this->_markupRate = $account->params->get('markup')/100;

		// Set the Discount
		$this->_discountRate = $account->params->get('discount')/100;
		$this->setItem($item);

		if($path = $this->app->path->path($this->resource)) {
			include $path;
		}
		$prices = $this->app->parameter->create($price);
		$this->_price_options = $this->app->parameter->create($prices->get($this->_group.'.item.option.'));
		$this->allowMarkup = $prices->get($this->_group.'.item.allowMarkup', true);
		$this->_base = $prices->get($this->_group.'.item.base');
		$this->_shipWeight = $prices->get($this->_group.'.shipping.weight');
		if($this->app->customer->isReseller()) {
			$this->_discountRate = $prices->get($this->_group.'.item.discount') ? $prices->get($this->_group.'.item.discount') : $this->_discountRate;
			$this->_markupRate = $this->allowMarkup ? $this->_markupRate : 0;
		}
		
	}
	public function get($name = 'retail', $formatted = false) {
		
		if(!method_exists($this, $name)) {
			$name = 'retail';
		}
		
		if ($formatted) {
			$price = $this->app->number->currency($this->$name(), array('currency' => 'USD'));
		} else {
			$price = (float) $this->$name();
		}
		
		return $price;
	}
	
	protected function reseller() {
		$base = $this->base();
		return (float) $base - ($base*$this->_discountRate);
	}
	protected function markup() {
		$base = $this->base();
		return (float) $base + ($base*$this->_markupRate);
	}
	protected function retail() {
		$retail = $this->base();
		$retail += $retail*$this->_markupRate;
		$retail -= $retail*$this->_discountRate;
		return (float) $retail;
	}
	protected function margin() {
		$margin = $this->markup() - $this->reseller();
		return (float) $margin;
	}
	protected function base() {
		$options = $this->getCalculatedOptions();
		return $this->_base + $options;
	}

	public function allowMarkups() {
		return $this->allowMarkup;
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
	public function getDiscountRate($format = false) {
		$result = $this->_discountRate;
		if($format) {
			return $this->app->number->toPercentage($result*100, 0);
		}
		return $result;
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
	public function setMarkupRate($value = null) {
		if(!is_null($value)) {
			$this->_markupRate = (float) $value;
		}
		return $this;
	}
	public function getProfitRate($format = false) {
		$profit = $this->_discountRate + $this->_markupRate;
		if($format) {
			$profit *= 100;
			$profit = $this->app->number->toPercentage($profit, 0);
		}
		return $profit;
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
		$this->setMarkupRate($item->markup);
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
            $price = $this->get('base');
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
    public function getShippingWeight() {
    	return $this->_shipWeight;
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