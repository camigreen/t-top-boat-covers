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
define('UPS_DEBUG', false);

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

/* @var string UPS_SHIPPER_ADDRESS_LINE2 Additional address information, preferably room or floor */
define('UPS_SHIPPER_ADDRESS_LINE2', '');

/* @var string UPS_SHIPPER_ADDRESS_LINE3 Additional address information, preferably department name */
define('UPS_SHIPPER_ADDRESS_LINE3', '');

/* @var string UPS_SHIPPER_CITY Shipper city */
define('UPS_SHIPPER_CITY', 'North Charleston');

/* @var string UPS_SHIPPER_STATEPROVINCE_CODE Shipper state or province */
define('UPS_SHIPPER_STATEPROVINCE_CODE', 'SC');

/* @var string UPS_SHIPPER_POSTAL_CODE Shipper postal code */
define('UPS_SHIPPER_POSTAL_CODE', '29418');

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

    private $destination;
    private $packages;


    public function setDestination($address) {

        $_address = new \SimpleUPS\Address();
        $_address->setStreet($address['addressLine1']);
        $_address->setCity($address['city']);
        if(isset($address['state'])) {
            $_address->setStateProvinceCode($address['state']);
        }
        
        $_address->setPostalCode($address['postalcode']);
        $_address->setCountryCode($address['countrycode']);
        if (UPS::isValidAddress($_address)) {
            echo 'address Validated';
            $correctedAddress = UPS::getCorrectedAddress($_address);
        } else if (UPS::isValidRegion($_address)) {
            var_dump(UPS::getSuggestedRegions($_address));
            $correctedAddress = $_address;
        } else {
            throw new ShipperException('The Destination address is not valid');
        }
        $this->destination = new \SimpleUPS\InstructionalAddress($correctedAddress);
        
        $this->destination->setAddressee($address['addressee']);
        $this->destination->setAddressLine2($address['addressLine2']);
        $this->destination->setAddressLine3($address['addressLine3']);
        $this->destination->validated = true;
        var_dump($this->destination);
        return $this;


    }

    protected function assemblePackages ($items) {
        $NewPackage = array(
            'height' => 0,
            'width' => 0,
            'length' => 0,
            'weight' => 0,
            'insurance' => 0
        );
        $packages = array();
        $package = $NewPackage;
        foreach($items as $item) {
            $items_in_box = 1;
            $qty = $item->qty;
            while($qty >= 1) {
                if(($package['weight'] + $item->shipping->weight) > $this->PackageWeightMax && $items_in_box >= 1) {
                    $packages[] = $package;
                    $package = $NewPackage;
                }
                $package['weight'] += $item->shipping->weight;
                $package['insurance'] += $item->price*$this->PackageInsuredValuePercentage;
                $items_in_box++;
                $qty--;
            }
        }
        $packages[] = $package;
        $this->packages = $packages;
    }

    public function getRates() {
        if(!$this->destination->validated)
            return;
        try {
            //define a package, we could specify the dimensions of the box if we wanted a more accurate estimate
            $package = new \SimpleUPS\Rates\Package();
            $package->setWeight('25')->setDeclaredValue(300.00,'USD');

            $shipment = new \SimpleUPS\Rates\Shipment();
            $shipment->setDestination($this->destination);
            $shipment->addPackage($package);
            $rates = UPS::getRates($shipment);
            echo 'Rates: ';

            echo '<ul>';
                foreach ($rates as $shippingMethod)
                    echo '<li>'.$shippingMethod->getService()->getDescription().' ($'.$shippingMethod->getTotalCharges().')</li>';

            echo '</ul>';

        } catch (ShipperException $e) {
            //doh, something went wrong
            echo 'Failed: ('.get_class($e).') '.$e->getMessage().'<br/>';
           echo 'Stack trace:<br/><pre>'.$e->getTraceAsString().'</pre>';
        }
        if (UPS::getDebug()) {
            UPS::getDebugOutput();
        }
        
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