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

    public function importItem($item = null) {
        parent::importItem($item);

        $this->price_group .= '.'.$this->alias;
        $this->attributes->set('boat_model.name', $this->name);
        $this->attributes->set('boat_model.value', $this->name);
        $this->name = 'T-Top Boat Cover';
    }
    

}


?>
