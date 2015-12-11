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
class ttopboatcoverStoreItem extends StoreItem {

    public $type = "ttopboatcover";
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
		
		$this->name = 'T-Top Boat Cover';
        $this->price_group = 'ttopboatcover.'.$this->attributes['boat_length']->get('value');

        if($item instanceof Item) {
        	$this->attributes['boat_model'] = $this->app->data->create();
	        $this->attributes['boat_model']->set('name', $this->name);
	        $this->attributes['boat_model']->set('value', $this->name);
	        list($oem) = $item->getRelatedCategories();
	        $this->attributes['oem'] = $this->app->data->create();
	        $this->attributes['oem']->set('name', $oem->name);
	        $this->attributes['oem']->set('value', $oem->id);
        }
        

        
    }
    

}


?>
