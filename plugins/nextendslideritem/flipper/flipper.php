<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.slideritem');

class plgNextendSliderItemFlipper extends plgNextendSliderItemAbstract {

    static $cssAdded = array();

    var $_identifier = 'flipper';

    var $_title = 'Flipper';

    function getTemplate() {
        return '
        <div style="line-height:0; width:{width}; {css}" class="nextend-smartslider-flip-container {flipclass}">
          <a href="{url}" target="{target}" style="background: none !important;display: block;">
            <div class="nextend-smartslider-flip">
                <img alt="{alt_esc}" src="{imagefront}" style="width: 100%;" class="nextend-smartslider-flip-front-img" > 
                <img alt="{alt_esc}" src="{imageback}" style="width: 100%;" class="nextend-smartslider-flip-back-img" >
            </div>
          </a>
        
          <style>
          '.$this->getCss('{{id}}').'
          </style>
        </div>';
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
        if($attr != '' && $link[0] == '#') $link[0] = ''; 
        
        $css = '';
        if(!isset(self::$cssAdded[$sliderid])){
            self::$cssAdded[$sliderid] = true;
            $css = '<style>'.$this->getCss($sliderid).'</style>';
        }
        
        return '
        <div style="line-height:0; width:'.$data->get('width', '').'; '.htmlspecialchars($data->get('css', '')).'" class="nextend-smartslider-flip-container '.$data->get('flipclass', '').'">
          '.($link[0] != '#' ? '<a '.$attr.' href="'.$link[0].'" target="'.$link[1].'" style="background: none !important;display: block;">' : '').'
            <div class="nextend-smartslider-flip">
                <img alt="'.htmlspecialchars($data->get('alt', '')).'" src="'.NextendUri::fixrelative($data->get('imagefront', '')).'" style="width: 100%;" class="nextend-smartslider-flip-front-img" > 
                <img alt="'.htmlspecialchars($data->get('alt', '')).'" src="'.NextendUri::fixrelative($data->get('imageback', '')).'" style="width: 100%;" class="nextend-smartslider-flip-back-img" >
            </div>
          '.($link[0] != '#' ? '</a>' : '').'
          '.$css.'
        </div>
        ';
    }
    
    function _renderAdmin($data, $id, $sliderid, $items){
    
        $link = (array)NextendParse::parse($data->get('link', ''));
        if(!isset($link[1])) $link[1] = '';
        
        return '
        <div style="line-height:0; width:'.$data->get('width', '').'; '.htmlspecialchars($data->get('css', '')).'" class="nextend-smartslider-flip-container '.$data->get('flipclass', '').'">
          '.($link[0] != '#' ? '<a href="'.$link[0].'" target="'.$link[1].'" style="background: none !important;display: block;">' : '').'
            <div class="nextend-smartslider-flip">
                <img alt="'.htmlspecialchars($data->get('alt', '')).'" src="'.NextendUri::fixrelative($data->get('imagefront', '')).'" style="width: 100%;" class="nextend-smartslider-flip-front-img" > 
                <img alt="'.htmlspecialchars($data->get('alt', '')).'" src="'.NextendUri::fixrelative($data->get('imageback', '')).'" style="width: 100%;" class="nextend-smartslider-flip-back-img" >
            </div>
          '.($link[0] != '#' ? '</a>' : '').'
        </div>
        ';
    }
    
    function getCss($id){
        return
'div#'.$id.' .nextend-smartslider-flip-container{
  position:relative;
}
div#'.$id.' .nextend-smartslider-flip{
  display:block;
  position: relative;
}
div#'.$id.' .nextend-smartslider-flip img{
  -webkit-backface-visibility:hidden;
  -moz-backface-visibility:hidden;
  -ms-backface-visibility:hidden;
  backface-visibility:hidden;
  border:1px solid transparent;
  
  -webkit-transition:all 0.5s;
  -moz-transition:all 0.5s;
  -ms-transition:all 0.5s;
  transition:all 0.5s;
  -moz-transform-origin:50% 50%;
  transform-origin:50% 50%;
}

div#'.$id.' .nextend-smartslider-flip-container .nextend-smartslider-flip-front-img{
    -moz-transform: perspective(800px) rotateY(0deg);
    -webkit-transform: perspective(800px) rotateY(0deg);
    transform: perspective(800px) rotateY(0deg);
}

div#'.$id.' .nextend-smartslider-flip-container:hover .nextend-smartslider-flip-front-img{
    -webkit-transform: perspective(800px) rotateY(-179.9deg);
    -moz-transform: perspective(800px) rotateY(-179.9deg);
    transform: perspective(800px) rotateY(-179.9deg);
}

div#'.$id.' .nextend-smartslider-flip .nextend-smartslider-flip-back-img{
    position:absolute;
    top:0;
    left:0;
    -moz-transform: perspective(800px) rotateY(180deg);
    -webkit-transform: perspective(800px) rotateY(180deg);
    transform: perspective(800px) rotateY(180deg);
}

div#'.$id.' .nextend-smartslider-flip-container:hover .nextend-smartslider-flip-back-img{
    -moz-transform: perspective(800px) rotateY(0deg);
    -webkit-transform: perspective(800px) rotateY(0deg);
    transform: perspective(800px) rotateY(0deg);
}';
    }

    function getValues() {
        return array(
            'imagefront' => NextendSmartSliderSettings::get('placeholder'),
            'imageback' => NextendSmartSliderSettings::get('placeholder'),
            'alt' => NextendText::_('Image_not_available'),
            'link' => '#|*|_self',
            'width' => '100%',
            'css' => '',
            'flipclass' => 'myflip',
            'onmouseclick' => '',
            'onmouseenter' => '',
            'onmouseleave' => ''
        );
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . $this->_identifier . DIRECTORY_SEPARATOR;
    }
}

NextendPlugin::addPlugin('nextendslideritem', 'plgNextendSliderItemFlipper');