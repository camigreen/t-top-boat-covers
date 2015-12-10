<?php 
use SimpleUPS\UPS;

/* @var string UPS_ACCESSLICENSENUMBER The UPS license number to be used in API requests */
define('UPS_ACCESSLICENSENUMBER', 'CCE85AD5154DDC46');

/* @var string UPS_ACCOUNTNUMBER The UPS account number to use in API requests */
define('UPS_ACCOUNTNUMBER', '');

/* @var string UPS_USERID The UPS user ID when logging into UPS.com */
define('UPS_USERID', 'ttopboatcovers');

/* @var string UPS_PASSWORD The UPS password when logging into UPS.com */
define('UPS_PASSWORD', 'admin2');

/* @var bool UPS_DEBUG The debug mode for this library */
define('UPS_DEBUG', FALSE);

/* @var bool UPS_CURRENCY_CODE Currency code to use for rates */
define('UPS_CURRENCY_CODE', 'USD');

 
/**
 * ----- SHIPPER DETAILS -----
 */

/* @var string UPS_SHIPPER_NUMBER */
define('UPS_SHIPPER_NUMBER', '01WV66');

/* @var string UPS_SHIPPER_ADDRESSEE Name of the company or addressee */
define('UPS_SHIPPER_ADDRESSEE', 'Laportes T-Top Boat Covers');

/* @var string UPS_SHIPPER_STREET Shipper street */
define('UPS_SHIPPER_STREET', '4651 Franchise Street');
// define('UPS_SHIPPER_STREET', '1123 Jerusalem Ave');

/* @var string UPS_SHIPPER_ADDRESS_LINE2 Additional address information, preferably room or floor */
define('UPS_SHIPPER_ADDRESS_LINE2', '');

/* @var string UPS_SHIPPER_ADDRESS_LINE3 Additional address information, preferably department name */
define('UPS_SHIPPER_ADDRESS_LINE3', '');

/* @var string UPS_SHIPPER_CITY Shipper city */
define('UPS_SHIPPER_CITY', 'North Charleston');
// define('UPS_SHIPPER_CITY', 'Uniondale');

/* @var string UPS_SHIPPER_STATEPROVINCE_CODE Shipper state or province */
define('UPS_SHIPPER_STATEPROVINCE_CODE', 'SC');
// define('UPS_SHIPPER_STATEPROVINCE_CODE', 'NY');

/* @var string UPS_SHIPPER_POSTAL_CODE Shipper postal code */
define('UPS_SHIPPER_POSTAL_CODE', '29418');
// define('UPS_SHIPPER_POSTAL_CODE', '11553');

/* @var string UPS_SHIPPER_COUNTRY_CODE Shipper country code */
define('UPS_SHIPPER_COUNTRY_CODE', 'US');

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
class ShipperHelper extends AppHelper {

    public $destination;
    protected $shipper;
    private $packages = array();
    public $packageWeightMax = 50;
    public $packageInsuredValuePercentage = .30;
    protected $availableShipMethods = array('03');
    protected $_rates;


    public function setDestination($address) {

        $destination = new \SimpleUPS\Address();
        $destination->setStreet($address->get('street1'));
        $destination->setCity($address->get('city'));
        $destination->setStateProvinceCode($address->get('state'));
        $destination->setPostalCode($address->get('postalCode'));
        $destination->setCountryCode('US');

        if(UPS::isValidRegion($destination)) {
           
        }
        if(UPS::isValidAddress($destination)) {
            
        } 
        $destination = UPS::getCorrectedAddress($destination);

        $this->destination = new \SimpleUPS\InstructionalAddress($destination);
        
        $this->destination->setAddressee($address->get('name'));
        $this->destination->setAddressLine2($address->get('street2', null));
        $this->destination->setAddressLine3($address->get('street3', null));
        return $this;
    }

    public function setShipper() {
        $address = new \SimpleUPS\InstructionalAddress();
        $address->setAddressee(UPS_SHIPPER_ADDRESSEE);
        $address->setAddressline2(UPS_SHIPPER_ADDRESS_LINE2);
        $address->setAddressline3(UPS_SHIPPER_ADDRESS_LINE3);
        $address->setCity(UPS_SHIPPER_CITY);
        $address->setStateProvinceCode(UPS_SHIPPER_STATEPROVINCE_CODE);
        $address->setPostalCode(UPS_SHIPPER_POSTAL_CODE);
        $address->setCountryCode(UPS_SHIPPER_COUNTRY_CODE);

        $shipper = new \SimpleUPS\Shipper();
        $shipper->setAddress($address);
        $shipper->setNumber(UPS_SHIPPER_NUMBER);

        $this->shipper = $shipper;

    }

    public function getShipper() {
        return $this->shipper;
    }

    public function validateDestination() {
        $destination = UPS::getCorrectedAddress($this->destination);

        $this->destination = new \SimpleUPS\InstructionalAddress($destination);
        
        $this->destination->setAddressee($address->get('name'));
        $this->destination->setAddressLine2($address->get('street2', null));
        $this->destination->setAddressLine3($address->get('street3', null));
        $this->destination->validated = true;
        return $this->destination;

    }

    public function assemblePackages ($items) {

        $newpackage = $this->app->parameter->create();
        $count = 1;
        foreach($items as $item) {
            $shipWeight = $item->getPrice()->getShippingWeight();
            $qty = $item->qty;
            while($qty >= 1) {
                if(($newpackage->get('weight', 0) + $shipWeight) > $this->packageWeightMax) {
                    $package = new \SimpleUPS\Rates\Package();
                    $package->setWeight($newpackage->get('weight'))->setDeclaredValue($newpackage->get('insurance'), 'USD');
                    $this->packages[] = $package;
                    $newpackage = $this->app->parameter->create();
                    $count = 1;
                }
                $newpackage->set('weight', $newpackage->get('weight', 0) + $shipWeight);
                $newpackage->set('insurance', $newpackage->get('insurance', 0.00) + $item->getPrice()->retail*$this->packageInsuredValuePercentage);
                $count++;
                $qty--;
            }
        }
        $package = new \SimpleUPS\Rates\Package();
        $package->setWeight($newpackage->get('weight'))->setDeclaredValue($newpackage->get('insurance'), 'USD');
        $this->packages[] = $package;
        // var_dump($this->packages);
        // return;
        return $this;
    }

    public function getRates() {

        //try {
            //define a package, we could specify the dimensions of the box if we wanted a more accurate estimate
            //$this->setShipper();
            //$shipper = $this->getShipper();
            
            $shipment = new \SimpleUPS\Rates\Shipment();
            $shipment->setDestination($this->destination);
            foreach($this->packages as $package) {
                $shipment->addPackage($package);
            }
            //$service = new \SimpleUPS\Service();
            //$service->setCode('03');
            //$shipment->setService($service);
            //$shipment->setShipper($shipper);
            $rates = UPS::getRates($shipment);
            foreach ($rates as $shippingMethod) {
                $this->_rates[$shippingMethod->getService()->getCode()] = $shippingMethod;
            }
            return $this->_rates;
                    

        //} catch (ShipperException $e) {
            //doh, something went wrong
            echo 'Failed: ('.get_class($e).') '.$e->getMessage().'<br/>';
           echo 'Stack trace:<br/><pre>'.$e->getTraceAsString().'</pre>';
        //}
        if (UPS::getDebug()) {
            UPS::getDebugOutput();
        }
        
    }

    public function getRateByMethod($method) {
        if(empty($this->_rates)) {
            $this->getRates();
        }
        if(isset($this->_rates[$method])) {
            return $this->_rates[$method]->getTotalCharges();
        }

        return 'Sevice Method Not Found.';

    }

    public function validateAddress($address) {
        try {
            if(!UPS::isValidAddress($address)) {
                return UPS::getCorrectedAddress($address);
            }
            return true;
        } catch(Exception $e) {
            echo 'Failed: ('.get_class($e).') '.$e->getMessage().'<br/>';
           echo 'Stack trace:<br/><pre>'.$e->getTraceAsString().'</pre>';
        }
        //UPS::getDebugOutput();
    }

    public function getPostalCodes($code) {

        $pc = new \SimpleUPS\PostalCodes();
        return $pc->get($code);

    }

    public function getAvailableShippingMethods() {
        $method = new \SimpleUPS\Service();
        $method->setCode('LP')->setDescription('Local Pickup - FREE');
        $methods[] = $method;
        foreach($this->availableShipMethods as $shipMethod) {
            $method = new \SimpleUPS\Service();
            $method->setCode($shipMethod);
            $description = $method->getDescription();
            $description = 'UPS - '. $description;
            $method->setDescription($description);
            $methods[] = $method;
        }

        return $methods;
 
    }

    
}

/**
 * The library was successfully able to communicate with the UPS API, and the
 * API determined that the authentication information provided is invalid.
 * @see   \SimpleUPS\UPS::setAuthentication()
 * @since 1.0
 */
class ShipperException extends \Exception
{


}