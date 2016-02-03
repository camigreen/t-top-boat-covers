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
class CCCStoreItem extends StoreItem {

   	/**
   	 * @var [string]
   	 */
   	public $model;
   	
    

    public function importItem($item = null) {
        parent::importItem($item);
        $this->id = 'ccc';
        $this->confirm = true;
        $this->type = 'ccc';
        $this->name = 'Center Console Curtain';
        $this->make = "LaPorte's T-Top Boat Covers";
        $this->price_group = 'ccc.'.$this->getOption('curtain_class')->get('value', 'A');
    }
    

}


?>