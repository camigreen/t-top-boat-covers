<?php

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
class CashRegister {
    
    public $order;
    
    public $payment;

    public $merchant;
    
    public $page;
    
    protected $taxRate = 0.07;
    
    protected $transactionID;
    
    protected $order_number;
    
    protected $order_date;
    
    protected $taxableStates = array('SC');
    
    public $total = 0;
    
    public $subtotal = 0;
    
    public $taxTotal = 0;
    
    Public $shipping = 0;
    
    public $taxExempt = false;
    
    public $app;
    
    protected $notification_emails = array();
    
    protected $shipper;
    

    public function __construct($app) {

        $app->loader->register('PageStore','classes:store/page.php');
        $this->app = $app;
        $this->merchant = $this->app->merchant->anet;
        if($id = $this->app->request->get('orderID','int')) {
            $this->order = $this->app->order->create($id);
        } else {
            $this->order = $this->app->order->create();
        }
        
        $this->page = new PageStore();
        $this->application = $this->app->zoo->getApplication();
        $this->setNotificationEmails();
    }
    
    protected function updateItemQty() {
        $update = $this->app->request->get('update','array');
        if($this->app->request->get('updated','string') == 'true') {
            foreach($update as $key => $item) {
                $this->items[$key]->qty = (int)$item['qty'];
            }
            $this->set('payment:creditCard:auth_code','');
        }
        
    }
    
    public function scanItems () {
        $cart = $this->app->cart;
        $this->order->items = $cart->get();
    }
    
    protected function setNotificationEmails() {
        $emails = array_map('trim', explode(',',$this->application->getParams()->get('global.store.notify_emails')));
        $this->notification_emails = array_merge($this->notification_emails,$emails);
    }
    
    public function sendNotificationEmail($order, $for = 'payment') {
        if(!$this->application->getParams()->get('global.store.notify_email_enable')) {
            return;
        }
        $email = $this->app->mail->create();
        $CR = $this;  
           if ($for == 'payment') {
                $filename = $this->app->pdf->workorder->setData($order)->generate()->toFile();
                $path = $this->app->path->path('assets:pdfs/'.$filename);
                $email->setSubject("T-Top Boat Cover Online Order Notification");
                $email->setBodyFromTemplate($this->application->getTemplate()->resource.'mail.checkout.order.php');
                $email->addRecipient($this->notification_emails);
                $email->addAttachment($path,'Order-'.$this->order->id.'.pdf');
                $email->Send();
                unlink($path);
            } 
            if($for == 'receipt') {
                $filename = $this->app->pdf->receipt->setData($order)->generate()->toFile();
                $path = $this->app->path->path('assets:pdfs/'.$filename);
                $email->setSubject("Thank you for your order.");
                $email->setBodyFromTemplate($this->application->getTemplate()->resource.'mail.checkout.receipt.php');
                $email->addRecipient($order->billing->get('email'));
                $email->addAttachment($path,'Receipt'.$this->order->id.'.pdf');
                $email->Send();
                unlink($path);
            } 
            if($for == 'error') {
                $email->setSubject("Error Notification");
                $_order = (string) $order;
                $email->setBody($_order);
                $email->addRecipient('sgibbons@palmettoimages.com');
                $email->Send();
            } 
        
    }

    public function setFormData() {
        if ($this->app->request->get('process','string', 'false') == 'false') {
            return;
        }
        
        if ($customer = $this->app->request->get('customer','array',null)) {
            $this->order->import($customer);
        }

        if($discount = $this->app->request->get('discount','float', 0)) {
            $this->order->discount = $discount;
            $this->order->updateSession();
        }
        
        if($service_fee = $this->app->request->get('service_fee','float', 0)) {
            $this->order->service_fee = $service_fee;
            $this->order->updateSession();
        }

        if ($payment = $this->app->request->get('payment','array',null)) {
            $this->order->import($payment);
        }
        
    }
    public function processOrder() {
        $this->order->orderDate = $this->app->date->create()->toSql();
        $this->order->save();

        return $this;
    }

    public function clearOrder() {
        $this->app->session->clear('order','checkout');
        $this->app->session->clear('cart','checkout');
    }

    
    public function getShippingRate() {
        $shipping = $this->order->get('shipping');
        if($this->order->get('localPickup') || !$shipping->get('zip')) {
            $this->shipping = 0;
        } else {
            $this->app->loader->register('Shipper','classes:store/shipper.php');
            $this->shipper = new Shipper($this->app, $this->order);
            $this->shipping = $this->shipper->getRate();
        }
            
        return $this->shipping;
    }
    
    private function clearTotals() {
        $this->subtotal = 0;
        $this->taxTotal = 0;
    }
    
    public function calculateTotals() {
        $this->clearTotals();
        foreach ($this->order->get('items') as $item) {
            $item->total = $item->price*$item->qty;
            $this->subtotal += $item->total;
            $this->taxTotal += ($item->taxable ? ($item->total*$this->taxRate) : 0);
        }
        
        if($this->taxExempt) {
            $this->taxTotal = 0;
        }

        if($this->order->discount > 0) {
            $this->subtotal -= $this->subtotal*$this->order->discount;
            $this->taxTotal -= $this->taxTotal*$this->order->discount;
        }

        if($this->order->service_fee > 0) {
            $this->subtotal += $this->subtotal*$this->order->service_fee;
            $this->taxTotal += $this->taxTotal*$this->order->service_fee;
        }

        $this->shipping = $this->getShippingRate();

        $this->total = $this->subtotal + $this->taxTotal + $this->shipping;

        $this->order->ship_total = $this->shipping;
        $this->order->subtotal = $this->subtotal;
        $this->order->tax_total = $this->taxTotal;
        $this->order->total = $this->total;
    }

    public function setTaxExempt() {
        $state = $this->order->get('billing')->get('state');
        if ($state) {
            $this->taxExempt = (!in_array($state,$this->taxableStates) && !$this->order->get('localPickup'));
        }
        $this->calculateTotals();
    }

    public function getCurrency($key) {
        if(property_exists($this, $key)) {
            return '$'.number_format(floatVal($this->$key),2,'.','');
        }
        return null;
    }

    public function import() {
        $this->order->setSalesPerson(); 
        $this->scanItems();
        $this->setFormData();
        $this->setTaxExempt();
        $this->calculateTotals();
    }

    public function processPayment() {
        if($this->app->request->get('bypass', 'boolean')) {
            $this->order->transaction_id = "Not Processed";
            $this->order->save();
            $result = array(
                'approved' => true,
                'orderID' => $this->order->id
            );
            $this->order->result = $result;

            $this->sendNotificationEmail($this->order, 'receipt');
            $this->sendNotificationEmail($this->order, 'payment');
            $this->clearOrder();
            
            return $this->order;
        }

        $order = $this->order;
        $billing = $order->get('billing');
        $shipping = $order->get('shipping');
        $items = $order->get('items');
        $creditCard = $order->get('creditCard');
        $sale = $this->merchant;
        
        $sale->card_num = $creditCard->get('cardNumber');
        $sale->exp_date = $creditCard->getExpDate();
        $sale->card_code = $creditCard->get('card_code');
        $sale->amount = $this->total;
        $sale->first_name = $billing->get('firstname');
        $sale->last_name = $billing->get('lastname');
        $sale->address = $billing->get('address');
        $sale->city = $billing->get('city');
        $sale->state = $billing->get('state');
        $sale->zip = $billing->get('zip');
//        $sale->country = $country = "US";
        $sale->phone = $billing->get('phoneNumber');
        $sale->setCustomField("CustomerAltNumber", $billing->get('altNumber'));
        $sale->email = $billing->get('email');
        $sale->customer_ip = $order->get('ip');
        $sale->invoice_num = $order->get('id');
        $sale->ship_to_first_name = $shipping->get('firstname');
        $sale->ship_to_last_name = $shipping->get('lastname');
        $sale->ship_to_address = $shipping->get('address');
        $sale->ship_to_city = $shipping->get('city');
        $sale->ship_to_state = $shipping->get('state');
        $sale->ship_to_zip = $shipping->get('zip');
//        $sale->ship_to_country = $ship_to_country = "US";
        $sale->tax = $tax = $this->taxTotal;
        $sale->freight = $this->shipping;
//        $sale->duty = $duty = "Duty1<|>export<|>15.00";
//        $sale->po_num = $po_num = "12";
        foreach($items as $item) {
            $sale->addLineItem(
                $item->id,
                str_replace('-',' ',substr($item->name,0,25)),// Item Name
                '',
//                str_replace('-',' ',substr($item->get('description'),0,31)),// Item Description
                $item->qty,// Item Quantity
                number_format($item->price,2,'.',''), // Item Unit Price
                ($item->taxable ? 'Y' : 'N')// Item taxable
            );
        }
        $response = $sale->authorizeAndCapture();
        
        if($response->approved) {
            $order->creditCard->set('cardNumber', $response->account_number);
            $order->creditCard->set('card_type', str_replace(' ','_',strtolower($response->card_type)));
            $order->creditCard->set('card_name', $response->card_type);
            $order->creditCard->set('auth_code', $response->authorization_code);
            $order->creditCard->set('approved', $response->approved);
            $order->creditCard->set('response', $response);
            $order->transaction_id = $response->transaction_id;
            $order->setStatus(1);
            $order->setOrderDate();
            if($this->app->merchant->testMode()) {
                //$order->id = 'Test Mode';
                $order->save();
            } else {
                $order->save();
            }
            
            $result = array(
                'approved' => $response->approved,
                'response' => $response,
                'orderID' => $order->id
            ); 
            $this->sendNotificationEmail($order, 'receipt');
            $this->sendNotificationEmail($order, 'payment');
            $this->clearOrder();

            //$order->updateSession();
        } else {
            $this->app->log->createLogger('email',array('sgibbons@palmettoimages.com'));
            $data = (string) $this->app->data->create($response);
            $this->app->log->notice($data,'Process Payment Failed');
            $result = array(
                'approved' => $response->approved,
                'response' => $response
            );
            //$this->sendNotificationEmail($result, 'error');
        }
        $order->result = $result;
        return $order;
    }
}

class CashRegisterException extends AppException {}
