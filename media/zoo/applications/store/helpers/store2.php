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
class Store2Helper extends AppHelper {
    
    protected $CartItems = array();
    protected $products = array();
    
    public $CashRegister;
    
    
    public function __construct($app) {
        parent::__construct($app);
        
        $app->loader->register('Store','classes:store.php');
        $app->loader->register('CartItem','classes:store/cartitem.php');
        $app->loader->register('CashRegister','classes:store/cashregister.php');
        $this->CashRegister = new CashRegister($app);
        
        
    }
    
    public function fillCart($items) {
        $items = (array)(is_string($items) ? $this->parseCart($items) : $items);
        
        foreach($items as $item) {
            $object = new CartItem($item);
            $this->cart[$object->sku] = $object;
        }
        
        return $this->cart;
    }
    
    
    
    public function registerProduct($products) {
        $products = (array)$products;
        foreach($products as $product) {
            $class = str_replace('-','',$product->type).'Product';
            if (file_exists($this->app->path->path('classes:store/'.strtolower($class).'.php'))) {
                $this->app->register($class,'classes:store/'.strtolower($class).'.php');
            } else {
                $class = 'Product';
                $this->app->register($class,'classes:store/'.$class.'.php');
            }
            
            $object = new Product($product);
            
            $this->products[] = $object;
        }
        
    }
    
    public function getProduct($id) {
        return $this->products[$id];
    }
    
    protected function parseCart($json) {
        $items = json_decode($json,true);
        $decoded = array();
        foreach($items as $key => $item) {
            $decoded[$key] = json_decode($item, true);
        }
        
        return $decoded;
    }
    
    public function createCustomerProfile($CR) {
        $this->app->merchant->anet();
        $customerProfile = new AuthorizeNetCustomer;
        $customerProfile->description = $CR->get('customer:billing:firstname').' '.$CR->get('customer:billing:lastname');
//        $customerProfile->merchantCustomerId = 123;
        $customerProfile->email = $CR->get('customer:email');

        // Add payment profile.
        $paymentProfile = new AuthorizeNetPaymentProfile;
        $paymentProfile->customerType = "individual";
        $paymentProfile->payment->creditCard->cardNumber = "4111111111111111";
        $paymentProfile->payment->creditCard->expirationDate = "2015-10";
        $customerProfile->paymentProfiles[] = $paymentProfile;

        // Add another payment profile.
        $paymentProfile2 = new AuthorizeNetPaymentProfile;
        $paymentProfile2->customerType = "business";
        $paymentProfile2->payment->bankAccount->accountType = "businessChecking";
        $paymentProfile2->payment->bankAccount->routingNumber = "121042882";
        $paymentProfile2->payment->bankAccount->accountNumber = "123456789123";
        $paymentProfile2->payment->bankAccount->nameOnAccount = "Jane Doe";
        $paymentProfile2->payment->bankAccount->echeckType = "WEB";
        $paymentProfile2->payment->bankAccount->bankName = "Pandora Bank";
        $customerProfile->paymentProfiles[] = $paymentProfile2;

        // Add shipping address.
        $address = new AuthorizeNetAddress;
        $address->firstName = "john";
        $address->lastName = "Doe";
        $address->company = "John Doe Company";
        $address->address = "1 Main Street";
        $address->city = "Boston";
        $address->state = "MA";
        $address->zip = "02412";
        $address->country = "USA";
        $address->phoneNumber = "555-555-5555";
        $address->faxNumber = "555-555-5556";
        $customerProfile->shipToList[] = $address;

        // Add another shipping address.
        $address2 = new AuthorizeNetAddress;
        $address2->firstName = "jane";
        $address2->lastName = "Doe";
        $address2->address = "11 Main Street";
        $address2->city = "Boston";
        $address2->state = "MA";
        $address2->zip = "02412";
        $address2->country = "USA";
        $address2->phoneNumber = "555-512-5555";
        $address2->faxNumber = "555-523-5556";
        $customerProfile->shipToList[] = $address2;
        
        $request = new AuthorizeNetCIM;

        $response = $request->createCustomerProfile($customerProfile);
    }
    
    public function processPayment($CR, $type = 'authorize', $merchant = 'anet') {
        $sale = $this->app->merchant->$merchant('live');
        
        $sale->card_num = $CR->payment->creditCard['cardNumber'];
        $sale->exp_date = $CR->payment->creditCard['expirationDate'];
        $sale->card_code = $CR->payment->creditCard['card_code'];
        $sale->amount = $CR->get('total');
        $sale->description = '';
        $sale->first_name = $CR->get('customer')->billing->firstname;
        $sale->last_name = $CR->get('customer')->billing->lastname;
//        $sale->company = '';
        $sale->address = $CR->get('customer')->billing->address;
        $sale->city = $CR->get('customer')->billing->city;
        $sale->state = $CR->get('customer')->billing->state;
        $sale->zip = $CR->get('customer')->billing->zip;
//        $sale->country = $country = "US";
        $sale->phone = $CR->get('customer')->billing->phoneNumber;
        $sale->setCustomField("CustomerAltNumber", $CR->get('customer')->billing->altNumber);
        $sale->email = $CR->get('customer')->email;
//        $sale->cust_id = $CR->get('payment:expirationDate');
        $sale->customer_ip = $CR->get('customer')->ip_address;
        $sale->invoice_num = $CR->get('order_number');
        $sale->ship_to_first_name = $CR->get('customer')->shipping->firstname;
        $sale->ship_to_last_name = $CR->get('customer')->shipping->lastname;
//        $sale->ship_to_company = $CR->get('payment:expirationDate');
        $sale->ship_to_address = $CR->get('customer')->shipping->address;
        $sale->ship_to_city = $CR->get('customer')->shipping->city;
        $sale->ship_to_state = $CR->get('customer')->shipping->state;
        $sale->ship_to_zip = $CR->get('customer')->shipping->zip;
//        $sale->ship_to_country = $ship_to_country = "US";
        $sale->tax = $tax = $CR->get('taxTotal');
        $sale->freight = $CR->get('shipping');
//        $sale->duty = $duty = "Duty1<|>export<|>15.00";
//        $sale->tax_exempt = $CR->get('payment:expirationDate');
//        $sale->po_num = $po_num = "12";
        foreach($CR->get('items') as $item) {
            $sale->addLineItem(
                $item->get('id'),
                str_replace('-',' ',substr($item->get('name'),0,25)),// Item Name
                '',
//                str_replace('-',' ',substr($item->get('description'),0,31)),// Item Description
                $item->get('qty'),// Item Quantity
                number_format($item->get('price'),2,'.',''), // Item Unit Price
                ($item->get('taxable') ? 'Y' : 'N')// Item taxable
            );
        }
        
        
        $data = array();
        switch ($type) {
            case 'authorize':
                $response = $sale->authorizeOnly();
                
                if($response->approved) {
                    $data['card_type'] = str_replace(' ','_',strtolower($response->card_type));
                    $data['card_name'] = $response->card_type;
                    $CR->set('payment:creditCard:auth_code', $response->transaction_id);
                    $CR->set('payment:creditCard:card_type', str_replace(' ','_',strtolower($response->card_type)));
                    $CR->set('payment:creditCard:card_name', $response->card_type);
                }
                $data['transfer'] = json_encode($CR->transfer());
                break;
            case 'capture':
                $capture = new AuthorizeNetAIM;
                $response = $capture->priorAuthCapture($CR->get('payment:creditCard:auth_code'));
                $CR->set('transactionID',$response->transaction_id);
                $CR->set('order_date',date('D M j, Y G:i:s T'));
                $data['transfer'] = json_encode($CR->transfer());
                
                break;
            case 'authorize|capture':
                $response = $sale->authorizeAndCapture();
                
                if($response->approved) {
                    $data['card_type'] = str_replace(' ','_',strtolower($response->card_type));
                    $data['card_name'] = $response->card_type;
                    $CR->payment->creditCard->cardNumber = $response->account_number;
                    $CR->payment->creditCard->auth_code = $response->transaction_id;
                    $CR->payment->creditCard->card_type = str_replace(' ','_',strtolower($response->card_type));
                    $CR->payment->creditCard->card_name = $response->card_type;
                    $CR->set('transactionID',$response->transaction_id);
                    $CR->set('order_date',date('D M j, Y G:i:s T'));
                }
                $data['transfer'] = $CR->transfer();
                break;
        }
        $data['response'] = $response;
        $data['approved'] = $response->approved;
        return $data;
    }
    
}

class StoreAppException extends AppException {}

