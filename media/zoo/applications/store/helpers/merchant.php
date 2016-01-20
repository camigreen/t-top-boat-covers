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

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class MerchantHelper extends AppHelper {

    protected $merchant;
    protected $testMode = false;
    protected $params;

    public function __construct($app) {

        parent::__construct($app);
        $application = $this->app->zoo->getApplication();
        $this->params = $application->getParams()->get('global.anet.');
        $this->params = $this->app->parameter->create($this->params);
        $this->testMode = (bool) $this->params->get('testing');
        
    }

    public function anet() {
        if($this->testMode) {
            define("AUTHORIZENET_API_LOGIN_ID", $this->params->get('sandbox_api_login_id'));
            define("AUTHORIZENET_TRANSACTION_KEY", $this->params->get('sandbox_api_transaction_key'));
            define("AUTHORIZENET_SANDBOX", true);
        } else {
            define("AUTHORIZENET_API_LOGIN_ID", $this->params->get('api_login_id'));
            define("AUTHORIZENET_TRANSACTION_KEY", $this->params->get('api_transaction_key'));
            define("AUTHORIZENET_SANDBOX", false);
        }

        $this->merchant['anet'] = new \AuthorizeNetAIM;

    }

    public function createProfile($profile) {
        $this->loadCreds();
        $request = new AuthorizeNetCIM;
        $profile = $request->createCustomerProfile($profile)->xml->profile->customerProfileID;
        return $profile; 
    }

    public function getProfile($id) {
        $this->loadCreds();
        $request = new AnetAPI\GetCustomerPaymentProfileRequest();
        $request->setRefId($id);
        $request->setMerchantAuthentication($this->loadCreds());
        $controller = new AnetController\GetCustomerPaymentProfileController($request);
        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
        if(($response != null)){
            if ($response->getMessages()->getResultCode() == "Ok")
            {
                echo "GetCustomerPaymentProfile SUCCESS: " . "\n";
                echo "Customer Payment Profile Id: " . $response->getPaymentProfile()->getCustomerPaymentProfileId() . "\n";
                echo "Customer Payment Profile Billing Address: " . $response->getPaymentProfile()->getbillTo()->getAddress(). "\n";
                echo "Customer Payment Profile Card Last 4 " . $response->getPaymentProfile()->getPayment()->getCreditCard()->getCardNumber(). "\n";
            }
            else
            {
                echo "GetCustomerPaymentProfile ERROR :  Invalid response\n";
                echo "Response : " . $response->getMessages()->getMessage()[0]->getCode() . "  " .$response->getMessages()->getMessage()[0]->getText() . "\n";
            }
        }
        else{
            echo "NULL Response Error";
        }
    }

    public function testMode() {
        return $this->testMode;
    }
    
    public function __get($name) {
        $this->$name();
        return $this->merchant[$name];
    }
    //put your code here
}
