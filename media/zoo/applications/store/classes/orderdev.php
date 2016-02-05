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
class OrderDev {

	public $id;
	public $created;
	public $created_by;
	public $modified;
	public $modified_by;
	public $params;
	public $elements;
	public $access = 12;
	public $status = 1;
	public $subtotal;
	public $tax_total;
	public $ship_total;
	public $account;
	public $total;

	public $app;

	protected $_user;
	protected $_account;
	
	public function __construct() {
	}

	public function save($writeToDB = false) {

		$tzoffset = $this->app->date->getOffset();
		$now        = $this->app->date->create();
		$cUser = $this->app->customer->get();

    	// set created date
		try {
            $this->created = $this->app->date->create($this->created, $tzoffset)->toSQL();
        } catch (Exception $e) {
            $this->created = $this->app->date->create()->toSQL();
        }
        $this->created_by = $cUser->id;

        // Set Modified Date
        $this->modified = $now->toSQL();
        $this->modified_by = $cUser->id; 

        $this->params->set('terms', $this->app->customer->get()->getParentAccount()->params->get('terms'));
        if($this->app->customer->isReseller()) {
        	$this->getTotal('reseller');
        } else {
        	$this->getTotal('retail');
        }

        $this->elements->set('ip', $this->app->useragent->ip());

		if($writeToDB) {
			$this->table->save($this);
		}

		
        $this->app->session->set('order',(string) $this,'checkout');

		return $this;

	}

	public function __toString () {
		$result = $this->app->parameter->create();
		$result->loadObject($this);
		$result->remove('app');
		return (string) $result;
	}

	/**
	 * Get the item published status
	 *
	 * @return int The item status
	 *
	 * @since 1.0
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Set the order status
	 *
	 * @param int  $status The new item status
	 * @param boolean $save  If the change should be saved to the database
	 *
	 * @return Order $this for chaining support
	 *
	 * @since 1.0
	 */
	public function setStatus($status, $save = false) {
		if ($this->status != $status) {

			// set status
			$old_status   = $this->status;
			$this->status = $status;

			// autosave order?
			if ($save) {
				$this->app->table->item->save($this);
			}

			// fire event
		    $this->app->event->dispatcher->notify($this->app->event->create($this, 'order:statusChanged', compact('old_status')));
		}

		return $this;
	}

	public function getOrderDate() {
		$tzoffset   = $this->app->date->getOffset();
		$date = $this->app->date->create($this->created, $tzoffset);
		return $date->format('m/d/Y g:i a');
	}

	public function getItemPrice($sku) {
		if(!$item = $this->elements->get('items.'.$sku)) {
			$item = $this->app->cart->get($sku);
			$item->getTotal();
		}
		$discount = $this->getAccount()->params->get('discount', 0)/100;
		return $item->total - ($item->total*$discount);
	}

	public function getSubtotal($display = 'retail') {

		if(!$items = $this->elements->get('items.')) {
			$items = $this->app->cart->getAllItems();
		}
		$this->subtotal = 0;
		foreach($items as $item) {
			$this->subtotal += $item->getTotal($display);
		}
		return $this->subtotal;
	}

	public function getShippingTotal($refresh = false) {
		if($this->isProcessed() || (!$refresh && $this->ship_total != 0)) {
			return $this->ship_total;
		}
        if(!$service = $this->elements->get('shipping_method')) {
            return 0;
        }
        $this->ship_total = 0;
        $application = $this->app->zoo->getApplication();
        $markup = $application->getParams()->get('global.shipping.ship_markup', 0);
        $markup = intval($markup)/100;
        $ship = $this->app->shipper;
        $ship_to = $this->app->parameter->create($this->elements->get('shipping.'));

        $rates = $ship->setDestination($ship_to)->assemblePackages($this->app->cart->getAllItems())->getRates();
        $rate = 0;
        foreach($rates as $shippingMethod) {
            if($shippingMethod->getService()->getCode() == $service) {
                $rate = $shippingMethod->getTotalCharges();
            }
        }
		$this->ship_total = $rate += ($rate * $markup);

        return $this->ship_total;
    }

    public function getTotal($display = 'retail') {
    	$this->total = $this->getSubTotal($display) + $this->getTaxTotal() + $this->getShippingTotal();
    	return $this->total;
    }

	public function isProcessed() {
		return $this->status > 1;
	}

	public function getUser() {
		if($this->created_by) {
			$this->_user = $this->app->account->get($this->created_by);
		}
		if(empty($this->_user)) {
			$this->_user = $this->app->customer->get();
			$this->created_by = $this->_user->id;
		}
		
		return $this->_user;
	}

	public function getAccount() {
		$this->_account = $this->app->customer->getParent();
		$this->account = $this->_account->id;
		return $this->_account;
	}

	public function getTaxTotal() {
		
		// Init vars
		$taxtotal = 0;
		$taxrate = 0.07;

		
		if(!$this->isTaxable()) {
			$this->tax_total = 0;
			return $this->tax_total;
		}

		if(!$items = $this->elements->get('items.')) {
			$items = $this->app->cart->getAllItems();
		}

		foreach($items as $item) {
			$taxtotal += ($item->taxable ? ($this->getItemPrice($item->sku)*$taxrate) : 0);
		}
		
		$this->tax_total = $taxtotal;
		return $this->tax_total;
	}

	public function calculateCommissions() {
		$application = $this->app->zoo->getApplication();
		$application->getCategoryTree();
		$items = $this->elements->get('items.');
		$account = $this->getAccount();
		$oems = $account->getAllOEMs();
		var_dump($this->elements);
		foreach($items as $item) {
			$_item = $this->app->table->item->get($item->id);
			$item_cat = $_item->getPrimaryCategory();
			foreach($oems as $oem) {
				if($item_cat->id == $oem->elements->get('category')) {
					$this->elements->set('commissions.accounts.'.$oem->id, $this->getItemPrice($item->sku)*$oem->elements->get('commission'));
				}
			}
			
		}
	}

	public function isTaxable() {

        $state = $this->elements->get('billing.state');
        $taxable = false;
        $taxable_states = array('SC');
        if ($state) {
            $taxable = (!in_array($state,$taxable_states) && !$this->elements->get('shipping_method'));
        }

        if($account = $this->getAccount()) {
            $taxable = $account->isTaxable();
        }
        return $taxable;
    }

    public function getShippingMethod() {
    	return JText::_('SHIPPING_METHOD_'.$this->elements->get('shipping_method'));
    }

}