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
    
    
    public function create($type, $secondary = null) {
    	include $this->app->path->path('prices:retail.php');
    	$prices = $prices[$type];
    	if($secondary) {
    		$result['item'] = $prices['item'][$secondary];
    		$result['shipping'] = $prices['shipping'][$secondary];
    		$prices = $result;
    	}
        return $this->app->data->create($prices);
    }
}

class StoreAppException extends AppException {}

