<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.slider');
nextendimport('nextend.data.data');
nextendimport('nextend.parse.parse');

class NextendSliderMagento extends NextendSlider{

    var $_data;
    
    var $_sliderid;

    function NextendSliderMagento($sliderid, &$params, $path, $backend = false) {
        parent::NextendSlider($path, $backend);
        
        $this->_sliderid = $sliderid;
    }
    
    function preRender(){
        
        $this->loadSlider($this->_sliderid);
        
        $this->setTypePath();
        $this->setInstance();
    }

    function setTypePath() {
        $type = $this->_slider->get('type', 'default');
        
        $class = 'plgNextendSlidertype' . $type;
        if (!class_exists($class, false)) {
            echo 'Error in slider type!';
            return false;
        }
        $this->_typePath = call_user_func(array($class, "getPath"));
    }
}