<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

class NextendSmartsliderAdminViewSliders_slider extends NextendView{
    
    function fontAction($tpl) {
        $this->xml = 'font';        
        $this->render('font');
    }
}
?>
