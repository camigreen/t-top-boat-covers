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
   	public $model;
   	
    

    public function importItem($item = null) {
        parent::importItem($item);

        $this->price_group = 'ttopboatcover.'.$this->attributes['boat_length']->get('value');

        if($item instanceof Item) {
          $this->name = 'T-Top Boat Cover';
        	$this->attributes['boat_model'] = $this->app->data->create();
	        $this->attributes['boat_model']->set('name', 'Boat Model');
	        $this->attributes['boat_model']->set('value', $item->name);
          $this->attributes['boat_model']->set('text', $item->name);
        }

        $this->make = "LaPorte's T-Top Boat Covers";
        $this->model = 'T-Top Boat Cover '.$this->attributes['oem']->get('name').' '.$this->attributes['boat_length']->get('value');
        

        
    }
    

}


?>
