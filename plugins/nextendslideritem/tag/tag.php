<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.slideritem');

class plgNextendSliderItemTag extends plgNextendSliderItemAbstract {

    var $_identifier = 'tag';

    var $_title = 'Tag';

    function getTemplate() {
        return "
        <div class='{fontclass}'>
          <a href='{url}' target='{target}'>
              <span class='nextend-smartslider-tag-{tagclass} {class}'>
                    {content}
              </span>
          </a>
          <style>
          ".$this->getCSS('{{id}}', '{tagclass}','{colora}','{colorhex}','{hovercolora}','{hovercolorhex}')."
          </style>
        </div>
        ";
    }
    
    function _render($data, $id, $sliderid, $items){
        
        $link = (array)NextendParse::parse($data->get('link', ''));
        if(!isset($link[1])) $link[1] = '';
        
        $colors = NextendColor::colorToCss($data->get('color2', '357cbdff'));
        $hovercolors = NextendColor::colorToCss($data->get('hovercolor2', '01add3ff'));
        
        $attr = '';
        $click = $data->get('onmouseclick', '');
        if(!empty($click)) $attr.= ' data-click="'.htmlspecialchars($click).'"';
        $enter = $data->get('onmouseenter', '');
        if(!empty($enter)) $attr.= ' data-enter="'.htmlspecialchars($enter).'"';
        $leave = $data->get('onmouseleave', '');
        if(!empty($leave)) $attr.= ' data-leave="'.htmlspecialchars($leave).'"';
    
        return '
        <div class="'.$data->get('fontclass').'" '.$attr.'>
        '.($link[0] != '#' ? '<a href="'.$link[0].'" target="'.$link[1].'">' : '').'
              <span class="nextend-smartslider-tag-'.$data->get('tagclass').' '.$data->get('class').'">
                    '.$data->get('content').'
              </span>
          '.($link[0] != '#' ? '</a>' : '').'
        
          <style>
          '.$this->getCSS($sliderid, $data->get('tagclass'), $colors[1], $colors[0], $hovercolors[1], $hovercolors[0]).'
          </style>
        </div>
        ';
    }
    
    function _renderAdmin($data, $id, $sliderid, $items){
        $link = (array)NextendParse::parse($data->get('link', ''));
        if(!isset($link[1])) $link[1] = '';
        
        $colors = NextendColor::colorToCss($data->get('color2', '357cbdff'));
        $hovercolors = NextendColor::colorToCss($data->get('hovercolor2', '01add3ff'));
    
        return '
        <div class="'.$data->get('fontclass').'">
        '.($link[0] != '#' ? '<a href="'.$link[0].'" target="'.$link[1].'">' : '').'
              <span class="nextend-smartslider-tag-'.$data->get('tagclass').' '.$data->get('class').'">
                    '.$data->get('content').'
              </span>
          '.($link[0] != '#' ? '</a>' : '').'
        
          <style>
          '.$this->getCSS($sliderid, $data->get('tagclass'), $colors[1], $colors[0], $hovercolors[1], $hovercolors[0]).'
          </style>
        </div>
        ';
    }
    
    function getCSS($id, $tagclass, $colora, $colorhex, $hovercolora, $hovercolorhex){
        return 
"div#".$id." span.nextend-smartslider-tag-".$tagclass."{
	float:right;
	height:24px;
	line-height: 24px !important;
	position:relative;
	padding:0 10px 0 12px !important;
	margin-left: 12px;
	background: #".$colorhex." !important;
	background: ".$colora." !important;
	-moz-border-radius-bottomright:4px;
	-webkit-border-bottom-right-radius:4px;	
	border-bottom-right-radius:4px;
	-moz-border-radius-topright:4px;
	-webkit-border-top-right-radius:4px;	
	border-top-right-radius:4px;	
} 

div#".$id." span.nextend-smartslider-tag-".$tagclass.":before{
	content:\"\";
	float:right;
	position:absolute;
	left:-9px;
	border-color:transparent #".$colorhex." transparent transparent;
	border-color:transparent ".$colora." transparent transparent;
	border-style:solid;
	border-width:12px 9px 12px 0;
}

div#".$id." span.nextend-smartslider-tag-".$tagclass.":after{
	content:\"\";
	position:absolute;
	top:10px;
	left:0;
	float:right;
	width:4px;
	height:4px;
	-moz-border-radius:99px;
	-webkit-border-radius:99px;
	border-radius:99px;
	background: #fff;
	-moz-box-shadow:0 1px 2px rgba(0, 0, 0, 0.2);
	-webkit-box-shadow:0 1px 2px rgba(0, 0, 0, 0.2);
	box-shadow:0 1px 2px rgba(0, 0, 0, 0.2);
}


div#".$id." span.nextend-smartslider-tag-".$tagclass.":hover{
  background:#".$hovercolorhex." !important;
  background:".$hovercolora." !important;
}	

div#".$id." span.nextend-smartslider-tag-".$tagclass.":hover:before{
  border-color: transparent #".$hovercolorhex." transparent transparent;
  border-color: transparent ".$hovercolora." transparent transparent;
}";
    }

    function getValues() {
        return array(
            'class' => '',
            'tagclass' => 'tagclass',
            'url' => '#',
            'target' => '_self',
            'content' => 'mytag',
            'fontclass' => 'sliderfont7',
            'color' => '#357cbd',
            'hovercolor' => '#01add3',
            'onmouseclick' => '',
            'onmouseenter' => '',
            'onmouseleave' => ''
        );
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . $this->_identifier . DIRECTORY_SEPARATOR;
    }
}

NextendPlugin::addPlugin('nextendslideritem', 'plgNextendSliderItemTag');