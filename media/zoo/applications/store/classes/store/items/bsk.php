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
        if(!$item instanceof Item) {
          if(isset($item['fromCart']) && $item['fromCart']) {
            $this->id = 'bsk-'.$this->options['kit_type']->get('value', 'aft');
          } else {
            $this->id = 'bsk';
          }
        } else {
          $this->id = 'bsk';
        }
        
        $this->confirm = true;
        $this->price_group = 'bsk.'.$this->getOption('kit_class')->get('value', 'A');
        $this->type = 'bsk';
        $this->make = "LaPorte's T-Top Boat Covers";
        
    }
    

}


?>