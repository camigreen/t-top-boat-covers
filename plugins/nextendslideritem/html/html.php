<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.slideritem');

class plgNextendSliderItemHtml extends plgNextendSliderItemAbstract {
    
    var $_identifier = 'html';
    
    var $_title = 'HTML';
    
    function getTemplate(){
        return '
        <div>
            {html}
            <style>            
              {css}
            </style>
        </div>
        ';
    }
    
    function _render($data, $id, $sliderid, $items){
        
        $attr = '';
        $click = $data->get('onmouseclick', '');
        if(!empty($click)) $attr.= ' data-click="'.htmlspecialchars($click).'"';
        $enter = $data->get('onmouseenter', '');
        if(!empty($enter)) $attr.= ' data-enter="'.htmlspecialchars($enter).'"';
        $leave = $data->get('onmouseleave', '');
        if(!empty($leave)) $attr.= ' data-leave="'.htmlspecialchars($leave).'"';
        
    
        $css = '';
        $cssCode = $data->get('css', '');
        if($cssCode){
            $css = '<style>'.$cssCode.'</style>';
        }
        
        return '<div '.$attr.'>'.$data->get('html', '').$css.'</div>';
    }
    
    function _renderAdmin($data, $id, $sliderid, $items){
    
        $css = '';
        $cssCode = $data->get('css', '');
        if($cssCode){
            $css = '<style>'.$cssCode.'</style>';
        }
        
        return '<div>'.$data->get('html', '').$css.'</div>';
    }
    
    function getValues(){
        return array(
            'html' => '<div class="myfirstclass">
'.NextendText::_('My_HTML_element').'
</div>',
            'css' => '.myfirstclass {
height: 30px;
line-height: 30px; 
background: royalblue;
color: white;
text-align: center;
}',
            'onmouseclick' => '',
            'onmouseenter' => '',
            'onmouseleave' => ''
        );
    }
    
    function getPath(){
        return dirname(__FILE__).DIRECTORY_SEPARATOR.$this->_identifier.DIRECTORY_SEPARATOR;
    } 
}

NextendPlugin::addPlugin('nextendslideritem', 'plgNextendSliderItemHtml');