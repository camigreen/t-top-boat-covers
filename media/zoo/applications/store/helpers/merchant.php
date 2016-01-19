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

    protected function loadCreds() {
        if($this->testMode) {
            define("AUTHORIZENET_API_LOGIN_ID", $this->params->get('sandbox_api_login_id'));
            define("AUTHORIZENET_TRANSACTION_KEY", $this->params->get('sandbox_api_transaction_key'));
            define("AUTHORIZENET_SANDBOX", true);
        } else {
            define("AUTHORIZENET_API_LOGIN_ID", $this->params->get('api_login_id'));
            define("AUTHORIZENET_TRANSACTION_KEY", $this->params->get('api_transaction_key'));
            define("AUTHORIZENET_SANDBOX", false);
        }
    }

    
    public function anet() {
        $this->loadCreds();
        $this->merchant['anet'] = new \AuthorizeNetAIM;

    }

    public function createProfile($profile) {
        $this->loadCreds();
        $request = new AuthorizeNetCIM;
        return $request->createCustomerProfile($profile);
    }

    public function getProfile($id) {
        $this->loadCreds();
        $request = new AuthorizeNetCIM;
        return $request->getCustomerProfile($id);
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
