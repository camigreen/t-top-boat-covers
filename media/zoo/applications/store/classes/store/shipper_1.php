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
class UPSShipper extends Store {
    
    protected $Total;
    
    protected $PackageWeightMax = 50;
    
    protected $PackageDeclaredValuePercentage = .30;
    
    protected $Request = array(
        'Request' => array(
            'RequestOption' => 'Rate',
            'CustomerClassification' => array(
                'Code' => '80',
                'Description' => 'Rates Associated with Shipper Number'
            )
        ),
        'Shipment' => array(
            'Service' => array(
                'Code' => '03',
                'Description' => 'Ground'
            ),
            'Shipper' => array(
                'Name' => 'T-Top Boat Covers',
                'ShipperNumber' => '01WV66',
                'Address' => array(
                    'AddressLine' => array(
                        '4651 Franchise Street'
                    ),
                    'City' => 'North Charleston',
                    'StateProvinceCode' => 'SC',
                    'PostalCode' => '29418',
                    'CountryCode' => 'US'
                )
            ),
            'ShipTo' => array(
                'Name' => null,
                'Address' => array(
                    'AddressLine' => array()
                ),
                'City' => null,
                'StateProvinceCode' => null,
                'PostalCode' => null,
                'CountryCode' => null
            ),
            'ShipmentRatingOptions' => array(
                'NegotiatedRatesIndicator' => ''
            ),
            'ShipmentServiceOptions' => '',
            'LargePackageIndicator' => ''
        )
 
    );
    
    public function __construct($app, $customer, $items) {
        $this->path = $app->path;
        $this->addShipTo($customer);
        $this->assemblePackages($items);
    }
    
    protected function addShipTo ($ShipTo) {
        $this->Request['Shipment']['ShipTo']['Name'] = $ShipTo->get('shipping:firstname').''.$ShipTo->get('shipping:lastname');
        $this->Request['Shipment']['ShipTo']['Address']['AddressLine'][] = $ShipTo->get('shipping:address');
        $this->Request['Shipment']['ShipTo']['Address']['City'] = $ShipTo->get('shipping:city');
        $this->Request['Shipment']['ShipTo']['Address']['StateProvinceCode'] = $ShipTo->get('shipping:state');
        $this->Request['Shipment']['ShipTo']['Address']['PostalCode'] = $ShipTo->get('shipping:zip');
        $this->Request['Shipment']['ShipTo']['Address']['CountryCode'] = 'US';
    }
    
    protected function assemblePackages ($items) {
        $NewPackage = array(
                    'PackagingType' => array(
                        'Code' => '02',
                        'Description' => 'Rate'
                    ),
                    'PackageWeight' => array(
                        'Weight' => 0,
                        'UnitOfMeasurement' => array(
                            'Code' => 'LBS',
                            'Description' => 'Pounds'
                        )
                    )
                );
        $packages = array();
        $package = $NewPackage;
        foreach($items as $item) {
            $items_in_box = 0;
            $box = 0;
            $qty = $item->qty;
            while($qty >= 1) {
                if(($package['PackageWeight']['Weight'] + $item->shipping->weight) > $this->PackageWeightMax && $items_in_box >= 1) {
                    $packages[$box] = $package;
                    $package = $NewPackage;
                    $box++;
                }
                $package['PackageWeight']['Weight'] += $item->shipping->weight;
//                $package->PackageServiceOptions['DeclaredValue']['MonetaryValue'] += $item->price;
                $items_in_box++;
                $qty--;
            }
        }
        $packages[$box] = $package;
        $this->Request['Shipment']['Package'] = $packages;
    }
    
    public function getRates() {
 
        
    }
}

class Package {

    public $box = array(
        'PackagingType' => array(
            'Code' => '02',
            'Description' => 'Rate'
        ),
        'PackageWeight' => array(
            'Weight' => 0,
            'UnitOfMeasurement' => array(
                'Code' => 'LBS',
                'Description' => 'Pounds'
            )
        )
    );
    public $items = array();
    
    public $ItemCount = 0;
    
    public function __construct() {
        echo 'New Package';
    }
    
    public function get() {

        $this->box['PackageWeight']['Weight'] = (string)$this->box['PackageWeight']['Weight'];
        return $this->box;
    }

}
//            'PackageServiceOptions' => $this->PackageServiceOptions