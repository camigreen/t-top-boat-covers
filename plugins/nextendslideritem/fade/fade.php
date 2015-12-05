<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.slideritem');

class plgNextendSliderItemFade extends plgNextendSliderItemAbstract {

    static $cssAdded = array();

    var $_identifier = 'fade';

    var $_title = 'Fade';

    function getTemplate() {
        return '
        <div style="{css_esc};line-height:0;position:relative;display:block;" class="nextend-smartslider-fade-container nextend-smartslider-fade-{fadeclass}" data-click="{onmouseclick_esc}" data-enter="{onmouseenter_esc}" data-leave="{onmouseleave_esc}">
          <a href="{url}" target="{target}" style="background: none !important; display:block;"> 
            <span class="nextend-smartslider-fade">
                <img alt="{alt_esc}" src="{imagefront}" style="max-width: 100%; width: {width};" class="nextend-smartslider-fade-front-img" >
                <img alt="{alt_esc}" src="{imageback}" style="max-width: 100%; width: {width};" class="nextend-smartslider-fade-back-img" >
                <style>
                  div#{{id}} .nextend-smartslider-fade-container .nextend-smartslider-fade .nextend-smartslider-fade-back-img{
                  	position:absolute;
                  	top:0;
                  	left:0;
                  	-webkit-transition:opacity .4s ease-in-out;
                  	-moz-transition:opacity .4s ease-in-out;
                  	-o-transition:opacity .4s ease-in-out;
                  	transition:opacity .4s ease-in-out;
                  	opacity:0
                  }
                  div#{{id}} .nextend-smartslider-fade-container .nextend-smartslider-fade:HOVER .nextend-smartslider-fade-back-img{
                  	opacity:0.9999;
                  }
                </style>
            </span>
          </a>
        </div>
        ';
    }
    
    function _render($data, $id, $sliderid, $items){
    
        $link = (array)NextendParse::parse($data->get('link', ''));
        if(!isset($link[1])) $link[1] = '';
        
        $attr = '';
        $click = $data->get('onmouseclick', '');
        if(!empty($click)) $attr.= ' data-click="'.htmlspecialchars($click).'"';
        $enter = $data->get('onmouseenter', '');
        if(!empty($enter)) $attr.= ' data-enter="'.htmlspecialchars($enter).'"';
        $leave = $data->get('onmouseleave', '');
        if(!empty($leave)) $attr.= ' data-leave="'.htmlspecialchars($leave).'"';
        
        $css = '';
        if(!isset(self::$cssAdded[$sliderid])){
            self::$cssAdded[$sliderid] = true;
            $css = 
'<style>
  div#nextend-smart-slider-0 .nextend-smartslider-fade-container .nextend-smartslider-fade .nextend-smartslider-fade-back-img{
  	position:absolute;
  	top:0;
  	left:0;
  	-webkit-transition:opacity .4s ease-in-out;
  	-moz-transition:opacity .4s ease-in-out;
  	-o-transition:opacity .4s ease-in-out;
  	transition:opacity .4s ease-in-out;
  	opacity:0
  }
  
  div#nextend-smart-slider-0 .nextend-smartslider-fade-container .nextend-smartslider-fade:HOVER .nextend-smartslider-fade-back-img{
  	opacity: 0.9999;
  }
</style>';
        }
        
        return
'<div style="'.htmlspecialchars($data->get('css', '')).';line-height:0;position: relative;display: block;" class="nextend-smartslider-fade-container nextend-smartslider-fade-'.$data->get('fadeclass', '').'" '.$attr.'>
  '.($link[0] != '#' ? '<a href="'.$link[0].'" target="'.$link[1].'" style="background: none !important; display:block;">' : '').'
    <span class="nextend-smartslider-fade">
        <img alt="'.htmlspecialchars($data->get('alt', '')).'" src="'.NextendUri::fixrelative($data->get('imagefront', '')).'" style="max-width: 100%; width: '.$data->get('width', '').';" class="nextend-smartslider-fade-front-img" >
        <img alt="'.htmlspecialchars($data->get('alt', '')).'" src="'.NextendUri::fixrelative($data->get('imageback', '')).'" style="max-width: 100%; width: '.$data->get('width', '').';" class="nextend-smartslider-fade-back-img" >
    </span>
  '.($link[0] != '#' ? '</a>' : '').'
  '.$css.'
</div>';
    }
    
    function _renderAdmin($data, $id, $sliderid, $items){
    
        $link = (array)NextendParse::parse($data->get('link', ''));
        if(!isset($link[1])) $link[1] = '';

        return
'<div style="'.htmlspecialchars($data->get('css', '')).';line-height:0;position: relative;display: block;" class="nextend-smartslider-fade-container nextend-smartslider-fade-'.$data->get('fadeclass', '').'">
  '.($link[0] != '#' ? '<a href="'.$link[0].'" style="background: none !important; display:block;">' : '').'
    <span class="nextend-smartslider-fade">
        <img alt="'.htmlspecialchars($data->get('alt', '')).'" src="'.NextendUri::fixrelative($data->get('imagefront', '')).'" style="max-width: 100%; width: '.$data->get('width', '').';" class="nextend-smartslider-fade-front-img" >
        <img alt="'.htmlspecialchars($data->get('alt', '')).'" src="'.NextendUri::fixrelative($data->get('imageback', '')).'" style="max-width: 100%; width: '.$data->get('width', '').';" class="nextend-smartslider-fade-back-img" >
        <style>
          div#nextend-smart-slider-0 .nextend-smartslider-fade-container .nextend-smartslider-fade .nextend-smartslider-fade-back-img{
          	position:absolute;
          	top:0;
          	left:0;
          	-webkit-transition:opacity .4s ease-in-out;
          	-moz-transition:opacity .4s ease-in-out;
          	-o-transition:opacity .4s ease-in-out;
          	transition:opacity .4s ease-in-out;
          	opacity:0
          }
          
          div#nextend-smart-slider-0 .nextend-smartslider-fade-container .nextend-smartslider-fade:HOVER .nextend-smartslider-fade-back-img{
          	opacity: 0.9999;
          }
        </style>
    </span>
  '.($link[0] != '#' ? '</a>' : '').'
</div>';
    }

    function getValues() {
        return array(
            'imagefront' => NextendSmartSliderSettings::get('placeholder'),
            'imageback' => NextendSmartSliderSettings::get('placeholder'),
            'alt' => NextendText::_('Image_not_available'),
            'link' => '#|*|_self',
            'width' => '100%',
            'css' => '',
            'fadeclass' => 'myfade',
            'onmouseclick' => '',
            'onmouseenter' => '',
            'onmouseleave' => ''
        );
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . $this->_identifier . DIRECTORY_SEPARATOR;
    }
}

NextendPlugin::addPlugin('nextendslideritem', 'plgNextendSliderItemFade');