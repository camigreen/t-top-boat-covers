<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controller
 *
 * @author Shawn
 */
class CartController extends JControllerLegacy {
    
    public function display ($cachable = false, $urlparams = Array()) {
                $view   = $this->input->get('view', 'orders');
		$layout = $this->input->get('layout', 'default');
                parent::display();
    }
}

?>
