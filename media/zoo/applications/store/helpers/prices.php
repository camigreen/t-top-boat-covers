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
class PricesHelper extends AppHelper {

    protected $items;
    protected $shipping;

    public function __construct($app) {
        parent::__construct($app);
        include $this->app->path->path('prices:prices.php');
        $this->items = $this->app->parameter->create($price);
        $this->shipping = $this->app->parameter->create();
        $this->account = $this->app->customer->get();
    }

    public function test() {
        include $this->app->path->path('prices:prices.php');
        $output = implode(', ', array_map(function ($v, $k) { return $k . '=' . $v; }, $prices['ubsk'], array_keys($prices['ubsk'])));
    }

    
    public function get($group, $markup = null) {   
        $markup = !is_null($markup) || $markup === 0 ? $markup : $this->account->params->get('markup')/100;

        $retail = $this->items->get($group);

        return $retail += ($retail*$markup);

    }

    public function getRetail($group) {
        return $this->get($group, 0);
    }

    public function getDiscount($group, $discount = null) {
        $discount = $discount || $discount == '0' ? $discount : $this->account->params->get('discount')/100;

        $retail = $this->getRetail($group);

        return $retail -= ($retail*$discount);

    }

    public function getMarkupList($group) {
        $default = (float) $this->account->params->get('markup')/100;
        $store = $this->app->account->getStoreAccount();
        $markups = $store->params->get('options.markup.');
        $list = array();
        foreach($markups as $value => $text) {
            $price = $this->get($group, $value/100);
            $diff = $this->getRetail($group) * ($value/100);
            $list[] = array('markup' => $value/100, 'price' => $price, 'formatted' => $this->currency($price), 'text' => $text.($text == 'No Markup' ? ' ' : ' Markup '), 'diff' => $diff,'default' => $default == $value/100 ? true : false);
        }

        return $list;
    }

    public function getShipping($group, $type = 'weight', $default = null, $formatCurrency = false, $currency = 'USD') {
        $search = $group.'.'.$type;
        $result = $this->shipping->get($search);

        if($formatCurrency) {
            return $this->formatCurrency($result, $currency);
        }

        return $result;
    }

    public function currency ($value, $currency = 'USD') {
        $value = (float) $value;
        return $this->app->number->currency($value ,array('currency' => $currency));
    }
}

