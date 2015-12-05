<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.slideritem');

class plgNextendSliderItemParagraph extends plgNextendSliderItemAbstract {
    
    var $_identifier = 'paragraph';
    
    var $_title = 'Paragraph';
    
    function getTemplate(){
        return '<p class="{fontclass} {class}" style="{fontsizer}{fontcolorr}{css_esc}">{content}</p>';
    }
    
    function _render($data, $id, $sliderid, $items){
        
        $fontsize = $data->get('fontsize', '');
        if(!empty($fontsize)) $fontsize = 'font-size:'.$fontsize.'%;';
        
        $fontcolors = (array)NextendParse::parse($data->get('fontcolor', ''));
        $fontcolor = '';
        if(isset($fontcolors[0]) && $fontcolors[0]){
            if(!empty($fontcolors[1])) $fontcolor = 'color:#'.$fontcolors[1].';';
        }
        
        $attr = '';
        $click = $data->get('onmouseclick', '');
        if(!empty($click)) $attr.= ' data-click="'.htmlspecialchars($click).'"';
        $enter = $data->get('onmouseenter', '');
        if(!empty($enter)) $attr.= ' data-enter="'.htmlspecialchars($enter).'"';
        $leave = $data->get('onmouseleave', '');
        if(!empty($leave)) $attr.= ' data-leave="'.htmlspecialchars($leave).'"';
        
        return '<p class="'.$data->get('fontclass', '').' '.$data->get('class', '').'" style="'.$fontsize.$fontcolor.htmlspecialchars($data->get('css', '')).'" '.$attr.'>'.$data->get('content', '').'</p>';
    }
    
    function _renderAdmin($data, $id, $sliderid, $items){
        
        $fontsize = $data->get('fontsize', '');
        if(!empty($fontsize)) $fontsize = 'font-size:'.$fontsize.'%;';
        
        $fontcolors = (array)NextendParse::parse($data->get('fontcolor', ''));
        $fontcolor = '';
        if(isset($fontcolors[0]) && $fontcolors[0]){
            if(!empty($fontcolors[1])) $fontcolor = 'color:#'.$fontcolors[1].';';
        }
        
        return '<p class="'.$data->get('fontclass', '').' '.$data->get('class', '').'" style="'.$fontsize.$fontcolor.htmlspecialchars($data->get('css', '')).'">'.$data->get('content', '').'</p>';
    }
    
    function getValues(){
        return array(
            'content' => NextendText::_('Empty_paragraph'),
            'fontclass' => 'sliderfont6',
            'fontsize' => 'auto',
            'fontcolor' => '0|*|000000',
            'css' => '',
            'class' => '',
            'onmouseclick' => '',
            'onmouseenter' => '',
            'onmouseleave' => ''            
        );
    }
    
    function getPath(){
        return dirname(__FILE__).DIRECTORY_SEPARATOR.$this->_identifier.DIRECTORY_SEPARATOR;
    } 
}

NextendPlugin::addPlugin('nextendslideritem', 'plgNextendSliderItemParagraph');