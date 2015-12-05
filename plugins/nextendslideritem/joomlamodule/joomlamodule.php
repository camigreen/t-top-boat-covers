<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.slideritem');

class plgNextendSliderItemJoomlaModule extends plgNextendSliderItemAbstract {
    
    var $_identifier = 'joomlamodule';
    
    var $_title = 'Joomla_module';
    
    function getTemplate(){
        return '<div>{{positiontype} {positionvalue}}</div>';
    }
    
    function _render($data, $id, $sliderid, $items){
        return '<div>{'.$data->get('positiontype', '').' '.$data->get('positionvalue', '').'}</div>';
    }
    
    function _renderAdmin($data, $id, $sliderid, $items){
        return $this->_render($data, $id, $sliderid, $items);
    }
    
    function getValues(){
        return array(
            'positiontype' => 'loadposition',
            'positionvalue' => ''
        );
    }
    
    function getPath(){
        return dirname(__FILE__).DIRECTORY_SEPARATOR.$this->_identifier.DIRECTORY_SEPARATOR;
    } 
}

NextendPlugin::addPlugin('nextendslideritem', 'plgNextendSliderItemJoomlaModule');