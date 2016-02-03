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
class UBSKStoreItem extends StoreItem {

   	/**
   	 * @var [string]
   	 */
   	public $model;
   	
    

    public function importItem($item = null) {
        parent::importItem($item);

        $this->id = 'ubsk';
        $this->confirm = true;
        $this->price_group = 'ubsk.'.$this->getOption('kit_class')->get('value', 'A');
        $this->type = 'bsk';
        $this->make = "LaPorte's T-Top Boat Covers";
        
    }
    

}


?>