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
class Shipper {
    
    public $app;
    
    protected $order;
    
    protected $packages;
    
    protected $PackageWeightMax = 50;
    
    protected $PackageInsuredValuePercentage = .30;
    
    protected $ShippingRateUpCharge = .90;
    
    public function __construct($app, $order) {
        $this->app = $app;
        $this->order = $order;
        $this->app->loader->register('Ups_Base','classes:store/Ups/Base.php');
        $this->app->loader->register('Ups_Ups','classes:store/Ups/Ups.php');
        $this->app->loader->register('Ups_BaseResponse','classes:store/Ups/BaseResponse.php');
        $this->assemblePackages($order->items);
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
    
    public function getRate() {

        $auth_params = array(
            'access_key'     => 'CCE85AD5154DDC46',
            'username'       => 'ttopboatcovers',
            'password'       => 'admin2',
            'account_number' => '01WV66',
        );
        
        $Ups = new Ups_Ups($auth_params);
        $origin = '29418';  
        $destination = $this->order->shipping->get('zip'); 
        $Ups->rates->set_destination($destination);
        $Ups->rates->set_origin($origin);
        
        $rate = $Ups->rates->get_rate($this->packages);
        $total = ($rate->rate*$this->ShippingRateUpCharge) + $rate->rate;
        return number_format($total, 2, '.', '');

    }
}
