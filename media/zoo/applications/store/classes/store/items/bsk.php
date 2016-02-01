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

    public $type = "bsk";
    /**
     * @var [string]
     */
    public $make = "LaPorte's T-Top Boat Covers";

   	/**
   	 * @var [string]
   	 */
   	public $model;
   	
    

    public function importItem($item = null) {
        parent::importItem($item);
        $this->type = 'bsk';
        $this->id = 'bsk';
    }
    

}


?>