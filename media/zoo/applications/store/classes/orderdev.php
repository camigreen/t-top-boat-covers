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
		$cUser = $this->app->customer->getUser();


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

        $this->params->set('terms', $this->app->customer->getAccount()->params->get('terms'));

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
			$item = $this->app->cart->create()->get($sku);
			$item->getTotal();
		}
		$discount = $this->getAccount()->params->get('discount', 0)/100;
		return $item->total - ($item->total*$discount);
	}

	public function getSubtotal($type = 'discount') {

		if(!$items = $this->elements->get('items.')) {
			$items = $this->app->cart->create()->getAllItems();
		}
		$this->subtotal = 0;
		foreach($items as $item) {
			$this->subtotal += $item->getTotal($type);
		}
		return $this->subtotal;
	}

	public function isProcessed() {
		return $this->id ? true : false;
	}

	public function getUser() {
		if($this->created_by) {
			$this->_user = $this->app->account->get($this->created_by);
		}
		if(empty($this->_user)) {
			$this->_user = $this->app->customer->getUser();
			$this->created_by = $this->_user->id;
		}
		
		return $this->_user;
	}

	public function getAccount() {
		$this->_account = $this->getUser()->getParentAccount();
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
			$items = $this->app->cart->create()->getAllItems();
		}

		foreach($items as $item) {
			$taxtotal += ($item->taxable ? ($this->getItemPrice($item->sku)*$taxrate) : 0);
		}
		
		$this->tax_total = $taxtotal;
		return $this->tax_total;
	}
	public function calculateTotals($type = 'discount') {

		if(!$this->isProcessed()) {
			$this->getSubtotal($type);
			$this->getTaxTotal();
		}

		$this->total = $this->subtotal + $this->tax_total + $this->ship_total;
		$totals['subtotal'] = $this->subtotal;
		$totals['taxtotal'] = $this->tax_total;
		$totals['shiptotal'] = $this->ship_total;
		$totals['total'] = $this->total;

		return $totals;
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