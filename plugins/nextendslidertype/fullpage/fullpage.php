<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

class plgNextendSliderTypeFullpage extends NextendPluginBase {
    
    var $_name = 'fullpage';
    
    function onNextendSliderTypeList(&$list){
        $list[$this->_name] = $this->getPath();
    }
    
    static function getPath(){
        return dirname(__FILE__).DIRECTORY_SEPARATOR.'fullpage'.DIRECTORY_SEPARATOR;
    }
}

NextendPlugin::addPlugin('nextendslidertype', 'plgNextendSliderTypeFullpage');