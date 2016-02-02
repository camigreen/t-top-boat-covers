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
class BSKStoreItem extends StoreItem {

   	/**
   	 * @var [string]
   	 */
   	public $model;
   	
    

    public function importItem($item = null) {
        parent::importItem($item);
        $this->type = 'bsk';
        $this->id = 'bsk';
        $this->name = 'Boat Shade Kit';
        $this->make = "LaPorte's T-Top Boat Covers";
        $this->price_group = 'bsk';
    }
    

}


?>