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
class PageStore {
    
    public $title;
    
    public $subtitle;
    
    public $id;
    
    public $complete = array();
    
    public $inProgress = array();
    
    public $buttons = array();
    
    public function __construct() {
        
    }
    
    public function addButton($id, $action, $label = '', $active = true, $disabled = false) {
        $this->buttons[$id] = array(
            'label' => $label,
            'active' => $active,
            'action' => $action,
            'disabled' => $disabled
        );
        return $this;
    }
    
    public function pageStatus($page) {
        foreach($this->complete as $p) {
            if ($p == $page) {
                return 'complete';
            }
        }
        foreach($this->inProgress as $p) {
            if ($p == $page) {
                return 'inProgress';
            }
        }
        return 'incomplete';
    }
    
    
}
