<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.slideritem');

class plgNextendSliderItemSpecial extends plgNextendSliderItemAbstract {

    var $_identifier = 'special';

    var $_title = 'Special';

    function getTemplate() {
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

    function getValues() {
        return array(
            'html' => '<div class="pin">
  <div class="circle"></div>      
  <div class="innercircle"></div>
  <div class="aura"></div>  
</div>',
            'css' => '.pin{
margin: 20px;
height: 20px;
}

.circle {
    background: none repeat scroll 0 0 #9f449b;
    border-radius: 99px 99px 99px 99px;
    height: 24px;
    position: absolute;
    width: 24px;
    opacity: .2;
}

.innercircle {
    background: #7b3678;
    border-radius: 99px 99px 99px 99px;
    margin: 3px;
    height: 18px;
    position: absolute;
    width: 18px;
    opacity: .5;
}

.aura {
border-radius:99px;
background:#9f449b;
position:absolute;
width:24px;
height:24px;
opacity:.4;
-webkit-animation:glow 1s ease-out infinite;
animation:glow 1s ease-out infinite;
-webkit-transform:scale3d(1,1,1);
-moz-transform:scale3d(1,1,1);
-ms-transform:scale3d(1,1,1);
-o-transform:scale3d(1,1,1);
transform:scale3d(1,1,1)
}

@-webkit-keyframes glow{0%,20%{
  opacity:.6;-webkit-transform:scale3d(1,1,1);
  -moz-transform:scale3d(1,1,1);
  -ms-transform:scale3d(1,1,1);
  -o-transform:scale3d(1,1,1);
  transform:scale3d(1,1,1)}

100%{
  opacity:0;
  -webkit-transform:scale3d(2,2,1);
  -moz-transform:scale3d(2,2,1);
  -ms-transform:scale3d(2,2,1);
  -o-transform:scale3d(2,2,1);
  transform:scale3d(2,2,1)}}

@keyframes glow{0%,20%{
  opacity:.6;
  -webkit-transform:scale3d(1,1,1);
  -moz-transform:scale3d(1,1,1);
  -ms-transform:scale3d(1,1,1);
  -o-transform:scale3d(1,1,1);
  transform:scale3d(1,1,1)}

100%{opacity:0;
  -webkit-transform:scale3d(2,2,1);
  -moz-transform:scale3d(2,2,1);
  -ms-transform:scale3d(2,2,1);
  -o-transform:scale3d(2,2,1);
  transform:scale3d(2,2,1)}}
',
            'onmouseclick' => '',
            'onmouseenter' => '',
            'onmouseleave' => ''
        );
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . $this->_identifier . DIRECTORY_SEPARATOR;
    }
}

NextendPlugin::addPlugin('nextendslideritem', 'plgNextendSliderItemSpecial');