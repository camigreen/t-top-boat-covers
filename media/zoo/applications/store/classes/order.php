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
class Order {

	public $id;
	public $billing;
	public $shipping;
	public $items;
	public $creditCard;
	public $salesperson;
	public $localPickup;
	public $ip;
	public $orderDate;
	public $status = 0;
	public $transaction_id;
	public $discount = 0;
	public $service_fee = 0;
	public $subtotal;
	public $tax_total;
	public $ship_total;
	public $total;
	public $access = 7;

	public $app;

	public function __construct() {

	}

	public function import($data) {
		foreach($data as $key => $value) {
			if(is_array($value)) {
				foreach($value as $k => $v) {
	            	if(!is_null($v) || $v != '') {

	            		if($k != 'email' || $k != 'confirm_email') {
	            			$this->$key->set($k,ucfirst(trim($v)));
	            		} else {
	            			$this->$key->set($k, trim($v));
	            		}
	            	}
            	}
			} else {
				if(!is_null($value) || $value != '') {
            		if(is_numeric($value)) {
            			$this->$key = trim($value);
            		} else {
            			$this->$key = ucfirst(trim($value));
            		}
            	}
			}
            
        }
        $this->localPickup = (bool) $this->localPickup;
        $this->updateSession();
	}

	public function canAccess($user = null) {
		return $this->app->user->canAccess($user, $this->access);
	}

	public function getStatus() {
		$statuses = array(
			0 => 'Not Processed',
			1 => 'Payment Approved',
			2 => 'Order Received',
			3 => 'In Production',
			4 => 'Shipped',
			5 => 'Refunded'
		);
		return $statuses[$this->status];
	}

	public function setStatus($status, $save = false) {
		if($this->status != $status) {
			$this->status = $status;
		}
		if($save) {
			$this->app->table->order->save($this);
		}
		return $this;
	}

	public function isOverdue($diff = null) {
		if(is_null($diff)) {
			return false;
		}
		$orderDate = strtotime($this->orderDate);
		$now = time();
		$secs = $now - $orderDate;
		$hours = round($secs/3600);
		$days = round($secs/86400);
		$age = array(
			'seconds' => $secs,
			'hours' => round($hours),
			'days' => round($days)
		);
		if($hours > $diff && $this->status < 4) {
			return true;
		}
		return false;
	}

	public function setOrderDate() {
		$tzoffset = $this->app->date->getOffset();
		$this->orderDate = $this->app->date->create('now', $tzoffset);
	}

	public function getOrderDate() {
		$date = $this->app->date->create($this->orderDate);
		return $date->format('m/d/Y g:i a');
	}

	public function updateSession() {
		$data = (string) $this;
		$this->app->session->set('order',$data,'checkout');
	}

	public function save() {
		$this->app->table->order->save($this);
		$this->app->session->set('order',$this,'checkout');
	}

	public function get($name) {
		return $this->$name;
	}

	public function set($key, $value) {
		$this->$key = $value;
	}

	public function setSalesPerson($id = null) {
		$salesperson = $this->app->salesperson->get($id);
		if($salesperson) {
			$this->salesperson = $salesperson->id;
		} else {
			$this->salesperson = false;
		}
		
    }

    public function getSalesPerson() {
    	$name = 'Website';
        if($this->salesperson) {
        	$name = $this->app->user->get($this->salesperson)->name;
        }
        return $name;
    }

    public function hasSalesperson() {
    	return (bool) $this->salesperson;
    }

	public function __toString() {
		foreach($this as $key => $value) {
			if($key != 'app') {
				$data[$key] = $value;
			}
		}
		$result = $this->app->data->create($data);
		return (string) $result;
	}
}