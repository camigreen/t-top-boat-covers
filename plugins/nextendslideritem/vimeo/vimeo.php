<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.slideritem');

class plgNextendSliderItemVimeo extends plgNextendSliderItemAbstract {
    
    var $_identifier = 'vimeo';
    
    var $_title = 'Vimeo';
    
    function getTemplate(){
    
        return '<img src="//secure-a.vimeocdn.com/images_v6/logo.png" style="width:100%;" />';
    }
    
    function _render($data, $id, $sliderid, $items){
    
        $js = NextendJavascript::getInstance();
        $js->addLibraryJsFile('jquery', dirname(__FILE__) . '/vimeo/vimeo.js');   
            
        return '<div id="'.$id.'" data-vimeocode="'.$data->get('vimeourl').'" data-autoplay="'.$data->get('autoplay', 0).'" data-reset="'.$data->get('reset', 0).'" data-title="'.$data->get('title', 1).'" data-byline="'.$data->get('byline', 1).'" data-portrait="'.$data->get('portrait', 1).'" data-loop="'.$data->get('loop', 0).'" data-color="'.$data->get('color', '00adef').'" ></div>
    <script type="text/javascript">
        njQuery(document).ready(function () {
            ssCreateVimeoPlayer("'.$id.'", "'.$sliderid.'");
        });
    </script>';
    }
    
    function _renderAdmin($data, $id, $sliderid, $items){
    
        return '<img src="//secure-a.vimeocdn.com/images_v6/logo.png" style="width:100%;" />';
    }
    
    function getValues(){
        return array(
            'code' => '75251217',
            'autoplay' => 0,
            'title' => 1,
            'byline' => 1,
            'portrait' => 0,
            'color' => '00adef',
            'loop' => 0
        );
    }
    
    function getPath(){
        return dirname(__FILE__).DIRECTORY_SEPARATOR.$this->_identifier.DIRECTORY_SEPARATOR;
    } 
}

NextendPlugin::addPlugin('nextendslideritem', 'plgNextendSliderItemVimeo');