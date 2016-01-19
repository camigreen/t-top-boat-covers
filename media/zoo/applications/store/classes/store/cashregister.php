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
    
    public $items;
    
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
    
    protected $shipper;
    

    public function __construct($app) {
        $app->loader->register('PageStore','classes:store/page.php');
        $this->app = $app;
        $this->merchant = $this->app->merchant->anet;
        $this->order = $this->app->orderdev->create();
        $this->application = $this->app->zoo->getApplication();

        $this->account = $this->app->customer->get();
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
        $this->order->items = $cart->getAllItems();
    }
    
    protected function getNotificationEmails() {
        return explode("\n", $this->app->account->getStoreAccount()->params->get('notify_emails'));
    }
    
    public function sendNotificationEmail($oid, $for = 'payment') {
        if(!$this->app->account->getStoreAccount()->params->get('notify_email_enable', true)) {
            return;
        }
        $order = $this->app->orderdev->get($oid);
        $email = $this->app->mail->create();
        $formType = $order->getAccount()->isReseller() ? 'reseller' : 'default';
        $CR = $this;  
           if ($for == 'payment') {
                $pdf = $this->app->pdf->create('workorder', $formType);
                $filename = $pdf->setData($order)->generate()->toFile();
                $path = $this->app->path->path('assets:pdfs/'.$filename);
                $email->setSubject("T-Top Boat Cover Online Order Notification");
                $email->setBodyFromTemplate($this->application->getTemplate()->resource.'mail.checkout.order.php');
                $email->addRecipient($this->getNotificationEmails());
                $email->addAttachment($path,'Order-'.$this->order->id.'.pdf');
                $email->Send();
                unlink($path);
            } 
            if($for == 'receipt') {
                $recipients = $order->getAccount()->getNotificationEmails();
                $recipients[] = $order->elements->get('email');
                $filename = $this->app->pdf->create('receipt', $formType)->setData($order)->generate()->toFile();
                $path = $this->app->path->path('assets:pdfs/'.$filename);
                $email->setSubject("Thank you for your order.");
                $email->setBodyFromTemplate($this->application->getTemplate()->resource.'mail.checkout.receipt.php');
                $email->addRecipient($recipients);
                $email->addAttachment($path,'Receipt-'.$this->order->id.'.pdf');
                $email->Send();
                unlink($path);
            } 
            if($for == 'invoice') {
                $addresses = $order->getAccount()->getNotificationEmails();
                $addresses[] = $order->elements->get('email');
                $filename = $this->app->pdf->create('invoice', $formType)->setData($order)->generate()->toFile();
                $path = $this->app->path->path('assets:pdfs/'.$filename);
                $email->setSubject("Thank you for your order.");
                $email->setBodyFromTemplate($this->application->getTemplate()->resource.'mail.checkout.invoice.php');
                $email->addRecipient($addresses);
                $email->addAttachment($path,'Invoice-'.$this->order->id.'.pdf');
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
        $this->order->save(true);

        return $this;
    }

    public function clearOrder() {
        $this->app->session->clear('order','checkout');
        $this->app->session->clear('cart','checkout');
    }

    
    public function getShippingRate($service = null) {
        if(!$service) {
            return 0;
        }
        $markup = $this->application->getParams()->get('global.shipping.ship_markup', 0);
        $markup = intval($markup)/100;
        $ship = $this->app->shipper;
        $ship_to = $this->app->parameter->create($this->order->elements->get('shipping.'));
        // var_dump($this->app->cart->getAllItems());
        // return;
        $rates = $ship->setDestination($ship_to)->assemblePackages($this->app->cart->getAllItems())->getRates();
        $rate = 0;
        foreach($rates as $shippingMethod) {
            if($shippingMethod->getService()->getCode() == $service) {
                $rate = $shippingMethod->getTotalCharges();
            }
        }

        return $rate += ($rate * $markup);
    }
    
    private function clearTotals() {
        $this->subtotal = 0;
        $this->taxTotal = 0;
    }

    public function processPayment($method) {

        switch($method) {
            case 'NET45':
            case 'NET30':
                return $this->_purchaseOrder();
                break;
            case 'DUR':
                return $this->_creditCard();
                break;
            case 'bypass':
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
                break;
            default:

        }
    }

    protected function _purchaseOrder () {

        $items = $this->app->cart;
        $this->order->params->set('payment.transaction_id', "Purchase Order");
        $this->order->elements->set('items.', $items->getAllItems());
        // Update Payment Status
        $this->order->params->set('payment.status', 2);
        $this->order->params->set('payment.type', 'PO');
        $this->order->setStatus(2);
        //this->order->calculateCommissions();
        $this->order->params->set('payment.approved', true);
        $this->order->save(true);
        $this->sendNotificationEmail($this->order->id, 'invoice');
        $this->sendNotificationEmail($this->order->id, 'payment');
        $this->clearOrder();
        
        return $this->order;
    }

    protected function _creditCard() {
        $order = $this->order;
        $billing = $order->elements->get('billing.');
        $shipping = $order->elements->get('shipping.');
        $items = $this->app->cart->getAllItems();
        $creditCard = $order->params->get('payment.creditcard.');
        $sale = $this->merchant;
        
        $sale->card_num = $creditCard['cardNumber'];
        $sale->exp_date = $creditCard['expMonth'].'/'.$creditCard['expYear'];
        $sale->card_code = $creditCard['card_code'];
        $sale->amount = $order->total;
        list($first, $last) = explode(' ', $shipping['name']);
        $sale->first_name = $first;
        $sale->last_name = $last;
        $sale->address = $billing['street1'].($billing['street2'] ? ', '.$billing['street2'] : '');
        $sale->city = $billing['city'];
        $sale->state = $billing['state'];
        $sale->zip = $billing['postalCode'];
//        $sale->country = $country = "US";
        $sale->phone = $billing['phoneNumber'];
        $sale->setCustomField("CustomerAltNumber", $billing['altNumber']);
        $sale->email = $order->elements->get('email');
        $sale->customer_ip = $order->elements->get('ip');
        $sale->invoice_num = $order->id;
        list($first, $last) = explode(' ', $shipping['name']);
        $sale->ship_to_first_name = $first;
        $sale->ship_to_last_name = $last;
        $sale->ship_to_address = $shipping['street1'] . ($shipping['street2'] ? ', ' . $shipping['street2'] : '');
        $sale->ship_to_city = $shipping['city'];
        $sale->ship_to_state = $shipping['state'];
        $sale->ship_to_zip = $shipping['postalCode'];
//        $sale->ship_to_country = $ship_to_country = "US";
        $sale->tax = $this->taxTotal;
        $sale->freight = $this->shipping;
//        $sale->duty = $duty = "Duty1<|>export<|>15.00";
//        $sale->po_num = $po_num = "12";
        $priceDisplay = ($this->app->customer->isReseller() ? 'reseller' : 'retail');
        foreach($items as $item) {
            $sale->addLineItem(
                $item->id,
                str_replace('-',' ',substr($item->name,0,25)),// Item Name
                '',
//                str_replace('-',' ',substr($item->get('description'),0,31)),// Item Description
                $item->qty,// Item Quantity
                number_format($item->getPrice()->get($priceDisplay),2,'.',''), // Item Unit Price
                ($item->taxable ? 'Y' : 'N')// Item taxable
            );
        }
        $response = $sale->authorizeAndCapture();

        
        if($response->approved) {
            $order->params->set('payment.creditcard.cardNumber', $response->account_number);
            $order->params->set('payment.creditcard.card_type', str_replace(' ','_',strtolower($response->card_type)));
            $order->params->set('payment.creditcard.card_name', $response->card_type);
            $order->params->set('payment.creditcard.auth_code', $response->authorization_code);
            $order->params->set('payment.approved', $response->approved);
            $order->params->set('payment.response_text', $response->response_reason_text);
            $order->params->set('payment.status', 3);
            $order->params->set('payment.type', 'CC');
            $order->elements->set('items.', $items);
            
            $order->setStatus(2);
            if($this->app->merchant->testMode()) {
                $order->params->set('payment.transaction_id','Test Mode');
                $order->save(true);
            } else {
                $order->params->set('payment.transaction_id',$response->transaction_id); ;
                $order->save(true);
            }
            $this->sendNotificationEmail($order->id, 'receipt');
            $this->sendNotificationEmail($order->id, 'payment');
            $this->clearOrder();

        } else {

            // trigger payment failure event
            $this->app->event->dispatcher->notify($this->app->event->create($this->order, 'order:paymentFailed', array('response' => $response)));
            $order->params->set('payment.approved', $response->approved);
            $order->params->set('payment.response_text', $response->response_reason_text);
        }

        return $order;
    }
}

class CashRegisterException extends AppException {}
