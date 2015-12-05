<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.slideritem');
nextendimport('nextend.image.color');

class plgNextendSliderItemCaption extends plgNextendSliderItemAbstract {

    static $cssAdded = array();

    var $_identifier = 'caption';

    var $_title = 'Caption';

    function getTemplate() {
        return '
          <div id="{{uuid}}">
            <a href="{url}" style="display: block; background: none !important;">
          		<div class="nextend-smartslider-caption {customcaptionclass}" style="width:{width}px; height:{height}px;">
          			<img alt="{alt_esc}" src="{image}" class="img-{captionclass}" />
          				<div class="caption nextend-smartslider-caption-{captionclass}" style="background:#{colorhex};background:RGBA({colora});">
          				  <h4 class="{fontclasstitle}">{content}</h4>
          					<p class="{fontclass}">{description}</p>
          				</div>
          		</div>
          	</a>
    
          	<script type="text/javascript">
                '.$this->getJs('{{id}}', '{{uuid}}').'
          	</script>
            
            <style>
            '.$this->getBaseCss('{{id}}').
            $this->getCSS('simple-bottom', '{{id}}').
            $this->getCSS('simple-left', '{{id}}').
            $this->getCSS('full-left', '{{id}}').
            $this->getCSS('full-right', '{{id}}').
            $this->getCSS('full-top', '{{id}}').
            $this->getCSS('full-bottom', '{{id}}').
            $this->getCSS('slide-left', '{{id}}').
            $this->getCSS('slide-right', '{{id}}').
            $this->getCSS('slide-top', '{{id}}').
            $this->getCSS('slide-bottom', '{{id}}').
            $this->getCSS('scale-left', '{{id}}').
            $this->getCSS('scale-right', '{{id}}').
            $this->getCSS('scale-top', '{{id}}').
            $this->getCSS('scale-bottom', '{{id}}').
            $this->getCSS('scale', '{{id}}').
            $this->getCSS('fade', '{{id}}').'
            </style>
        </div>
        ';
    }
    
    function _render($data, $id, $sliderid, $items){
        $link = (array)NextendParse::parse($data->get('link', ''));
        if(!isset($link[1])) $link[1] = '';
        
        $colors = NextendColor::colorToCss($data->get('color', '00000080'));
        
        $size = (array)NextendParse::parse($data->get('size', ''));
        if(!isset($size[0])) $size[0] = '100';
        if(!isset($size[1])) $size[1] = '100';
        
        $attr = '';
        $click = $data->get('onmouseclick', '');
        if(!empty($click)) $attr.= ' data-click="'.htmlspecialchars($click).'"';
        $enter = $data->get('onmouseenter', '');
        if(!empty($enter)) $attr.= ' data-enter="'.htmlspecialchars($enter).'"';
        $leave = $data->get('onmouseleave', '');
        if(!empty($leave)) $attr.= ' data-leave="'.htmlspecialchars($leave).'"';
        
        $css = '';
        if(!isset(self::$cssAdded[$sliderid])){
            self::$cssAdded[$sliderid] = array();
            $css.= $this->getBaseCss($sliderid);
        }
        
        $captionclass = $data->get('captionclass', '');
        
        if(!isset(self::$cssAdded[$sliderid][$captionclass])){
            self::$cssAdded[$sliderid][$captionclass] = true;
            $css.= $this->getCSS($captionclass, $sliderid);
        }
        if($css != '') $css = '<style>'.$css.'</style>';
    
        return '
          <div id="'.$id.'" '.$attr.'>
            '.($link[0] != '#' ? '<a href="'.$link[0].'" target="'.$link[1].'" style="display: block; background: none !important;">' : '').'
          		<div class="nextend-smartslider-caption '.$data->get('customcaptionclass', '').'" style="width:'.$size[0].'px; height:'.$size[1].'px;">
          			<img alt="'.htmlspecialchars($data->get('alt', '')).'" src="'.NextendUri::fixrelative($data->get('image', '')).'" class="img-'.$data->get('captionclass', '').'" />
          				<div class="caption nextend-smartslider-caption-'.$data->get('captionclass', '').'" style="background:#'.$colors[0].';background:'.$colors[1].';">
          				  <h4 class="'.$data->get('fontclasstitle', '').'">'.$data->get('content', '').'</h4>
          					<p class="'.$data->get('fontclass', '').'">'.$data->get('description', '').'</p>
          				</div>
          		</div>
            '.($link[0] != '#' ? '</a>' : '').'
    
          	<script type="text/javascript">
                '.$this->getJs($sliderid, $id).'
          	</script>
            '.$css.'
        </div>
        ';
    }
    
    function _renderAdmin($data, $id, $sliderid, $items){
        $link = (array)NextendParse::parse($data->get('link', ''));
        if(!isset($link[1])) $link[1] = '';
        
        $colors = NextendColor::colorToCss($data->get('color', '00000080'));
        
        $size = (array)NextendParse::parse($data->get('size', ''));
        if(!isset($size[0])) $size[0] = '100';
        if(!isset($size[1])) $size[1] = '100';
    
        return '
          <div id="'.$id.'">
            '.($link[0] != '#' ? '<a href="'.$link[0].'" target="'.$link[1].'" style="display: block; background: none !important;">' : '').'
          		<div class="nextend-smartslider-caption '.$data->get('customcaptionclass', '').'" style="width:'.$size[0].'px; height:'.$size[1].'px;">
          			<img alt="'.htmlspecialchars($data->get('alt', '')).'" src="'.NextendUri::fixrelative($data->get('image', '')).'" class="img-'.$data->get('captionclass', '').'" />
          				<div class="caption nextend-smartslider-caption-'.$data->get('captionclass', '').'" style="background:#'.$colors[0].';background:'.$colors[1].';">
          				  <h4 class="'.$data->get('fontclasstitle', '').'">'.$data->get('content', '').'</h4>
          					<p class="'.$data->get('fontclass', '').'">'.$data->get('description', '').'</p>
          				</div>
          		</div>
            '.($link[0] != '#' ? '</a>' : '').'
    
          	<script type="text/javascript">
                '.$this->getJs($sliderid, $id).'
          	</script>
        </div>
        ';
    }
    
    function getJs($id, $uid){
        return 
'if(typeof window.ssitemmarker == \'undefined\' && window[\''.$id.'-onresize\']){
    (function(){
        var index = window[\''.$id.'-onresize\'].push(function(ratio){
            window.lastratio = ratio;
            var node = njQuery(\'#'.$uid.'\').find(\'.nextend-smartslider-caption\');
            var w = node.data(\'ss-w\'),
                h = node.data(\'ss-h\');
            if(!w){
                node.data(\'ss-w\', node.width());
                w = node.data(\'ss-w\');
            }
            if(!h){
                node.data(\'ss-h\', node.height());
                h = node.data(\'ss-h\');
            }
            node.width(w*ratio);
            node.height(h*ratio);
        }) - 1;
        if(window.ssadmin){
            window[\''.$id.'-onresize\'][index](window.lastratio);
        }
    })();
}';
    }
    
    function getBaseCss($id){
        return 
'div#'.$id.' .nextend-smartslider-caption{
	float: left;
	position: relative;
	overflow: hidden;   
}

div#'.$id.' .nextend-smartslider-caption img,
div#'.$id.' .nextend-smartslider-caption .caption{ 
    position: absolute;
    left: 0;
    -webkit-transition: all 0.4s ease-out 0s;
    -moz-transition: all 0.4s ease-out 0s;
    -ms-transition: all 0.4s ease-out 0s;
    -o-transition: all 0.4s ease-out 0s;
    transition: all 0.4s ease-out 0s;
	width: 100%;
	height: 100%;
}          

div#'.$id.' .nextend-smartslider-caption .caption{
	  z-index: 2;
    margin: 0;
}
            
div#'.$id.' .nextend-smartslider-caption .caption h4{
    padding:  20px 20px 5px;
    margin: 0;
}


div#'.$id.' .nextend-smartslider-caption .caption p{
  padding: 0 20px;
  margin: 0;
}
';
    }
    
    function getCSS($type, $id){
        switch($type){
            case 'simple-bottom':
                return 
'div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-simple-bottom h4,
div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-simple-left h4{
  padding:  5px 10px;
  margin: 0;
  text-align: center !important;
}            

div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-simple-bottom{
  height: auto;
  bottom: -100%;
}

div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-simple-bottom p{
    display: none;
}

div#'.$id.' .nextend-smartslider-caption:HOVER .caption.nextend-smartslider-caption-simple-bottom,
div#'.$id.' .nextend-smartslider-caption:FOCUS .caption.nextend-smartslider-caption-simple-bottom,
div#'.$id.' .nextend-smartslider-caption:ACTIVE .caption.nextend-smartslider-caption-simple-bottom{
  bottom: 0;
}';
            case 'simple-left':
                return
'div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-simple-left{
  left: -100%;
  height: auto;;
  bottom: 0px;
}

div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-simple-left p{
    display: none;
}

div#'.$id.' .nextend-smartslider-caption:HOVER .caption.nextend-smartslider-caption-simple-left,
div#'.$id.' .nextend-smartslider-caption:FOCUS .caption.nextend-smartslider-caption-simple-left,
div#'.$id.' .nextend-smartslider-caption:ACTIVE .caption.nextend-smartslider-caption-simple-left{
  left: 0;
}';

            case 'full-top':
                return
'div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-full-top{
    top: -100%;
}


div#'.$id.' .nextend-smartslider-caption:HOVER .caption.nextend-smartslider-caption-full-top,
div#'.$id.' .nextend-smartslider-caption:FOCUS .caption.nextend-smartslider-caption-full-top,
div#'.$id.' .nextend-smartslider-caption:ACTIVE .caption.nextend-smartslider-caption-full-top{
    top: 0;
}';

            case 'full-bottom':
                return
'div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-full-bottom{
    bottom: -100%;
}

div#'.$id.' .nextend-smartslider-caption:HOVER .caption.nextend-smartslider-caption-full-bottom,
div#'.$id.' .nextend-smartslider-caption:FOCUS .caption.nextend-smartslider-caption-full-bottom,
div#'.$id.' .nextend-smartslider-caption:ACTIVE .caption.nextend-smartslider-caption-full-bottom{
    bottom: 0;
}';

            case 'full-right':
                return
'div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-full-right{
    left: 100%;
    top: 0;
}            

div#'.$id.' .nextend-smartslider-caption:HOVER .caption.nextend-smartslider-caption-full-right,
div#'.$id.' .nextend-smartslider-caption:FOCUS .caption.nextend-smartslider-caption-full-right,
div#'.$id.' .nextend-smartslider-caption:ACTIVE .caption.nextend-smartslider-caption-full-right{
    left: 0;
}';

            case 'full-left':
                return
'div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-full-left{
    left: -100%;
    top: 0;
}            

div#'.$id.' .nextend-smartslider-caption:HOVER .caption.nextend-smartslider-caption-full-left,
div#'.$id.' .nextend-smartslider-caption:FOCUS .caption.nextend-smartslider-caption-full-left,
div#'.$id.' .nextend-smartslider-caption:ACTIVE .caption.nextend-smartslider-caption-full-left{
    left: 0;
}';

            case 'slide-right':
                return
'div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-slide-right{
    left: 100%;
}

div#'.$id.' .nextend-smartslider-caption:HOVER .caption.nextend-smartslider-caption-slide-right,
div#'.$id.' .nextend-smartslider-caption:FOCUS .caption.nextend-smartslider-caption-slide-right,
div#'.$id.' .nextend-smartslider-caption:ACTIVE .caption.nextend-smartslider-caption-slide-right{
	left: 0;
}

div#'.$id.' .nextend-smartslider-caption:HOVER  .img-slide-right{
	left: -100%;
}';

            case 'slide-left':
                return
'div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-slide-left{
    left: -100%;
}

div#'.$id.' .nextend-smartslider-caption:HOVER .caption.nextend-smartslider-caption-slide-left,
div#'.$id.' .nextend-smartslider-caption:FOCUS .caption.nextend-smartslider-caption-slide-left,
div#'.$id.' .nextend-smartslider-caption:ACTIVE .caption.nextend-smartslider-caption-slide-left{
	left: 0;
}

div#'.$id.' .nextend-smartslider-caption:HOVER  .img-slide-left{
	left: 100%;
}';

            case 'slide-top':
                return
'div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-slide-top{
    top: -100%;
}

div#'.$id.' .nextend-smartslider-caption:HOVER .caption.nextend-smartslider-caption-slide-top,
div#'.$id.' .nextend-smartslider-caption:FOCUS .caption.nextend-smartslider-caption-slide-top,
div#'.$id.' .nextend-smartslider-caption:ACTIVE .caption.nextend-smartslider-caption-slide-top{
	top: 0;
}

div#'.$id.' .nextend-smartslider-caption  .img-slide-top{
	top: 0;
}  

div#'.$id.' .nextend-smartslider-caption:HOVER  .img-slide-top{
	top: 100%;
}';

            case 'slide-bottom':
                return
'div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-slide-bottom{
  bottom: -100%;
}

div#'.$id.' .nextend-smartslider-caption:HOVER .caption.nextend-smartslider-caption-slide-bottom,
div#'.$id.' .nextend-smartslider-caption:FOCUS .caption.nextend-smartslider-caption-slide-bottom,
div#'.$id.' .nextend-smartslider-caption:ACTIVE .caption.nextend-smartslider-caption-slide-bottom{
	bottom: 0;
}            

div#'.$id.' .nextend-smartslider-caption .img-slide-bottom{
	top: 0%;
}
                
div#'.$id.' .nextend-smartslider-caption:HOVER .img-slide-bottom{
	top: -100%;
}';

            case 'scale':
                return 
'div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-scale{
  opacity: 0;
}

div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-scale h4,
div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-scale p{     
	left: -100%;
	position: relative;
  -webkit-transition: all 0.4s ease-out 100s;
  -moz-transition: all 0.4s ease-out 100s;
  -ms-transition: all 0.4s ease-out 100s;
  -o-transition: all 0.4s ease-out 100s;
  transition: all 0.4s ease-out 100s;
}

div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-scale h4,
div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-scale p{
	-webkit-transition-delay: 300ms;
	-moz-transition-delay: 300ms;
	-o-transition-delay: 300ms;
	-ms-transition-delay: 300ms;	
	transition-delay: 300ms;
}            

div#'.$id.' .nextend-smartslider-caption:HOVER .img-scale{
	-moz-transform: scale(1.4);
	-o-transform: scale(1.4);
	-webkit-transform: scale(1.4);
	transform: scale(1.4);
}            

div#'.$id.' .nextend-smartslider-caption:HOVER .caption.nextend-smartslider-caption-scale h4,
div#'.$id.' .nextend-smartslider-caption:HOVER .caption.nextend-smartslider-caption-scale p{
	left: 0;
}            

div#'.$id.' .nextend-smartslider-caption:HOVER .caption.nextend-smartslider-caption-scale{
	opacity: 1;    
}';

            case 'scale-left':
                return 
'div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-scale-left{
	left: -100%;
}    

div#'.$id.' .nextend-smartslider-caption:HOVER .img-scale-left{
	-moz-transform: scale(1.4);
	-o-transform: scale(1.4);
	-webkit-transform: scale(1.4);
	transform: scale(1.4);
}            

div#'.$id.' .nextend-smartslider-caption:HOVER .caption.nextend-smartslider-caption-scale-left{
	left: 0;
}';

            case 'scale-right':
                return 
'div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-scale-right{
	left: 100%;
}    

div#'.$id.' .nextend-smartslider-caption:HOVER .img-scale-right{
	-moz-transform: scale(1.4);
	-o-transform: scale(1.4);
	-webkit-transform: scale(1.4);
	transform: scale(1.4);
}            

div#'.$id.' .nextend-smartslider-caption:HOVER .caption.nextend-smartslider-caption-scale-right{
	left: 0;
}';

            case 'scale-bottom':
                return
'div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-scale-bottom{
	bottom: -100%;
}    

div#'.$id.' .nextend-smartslider-caption:HOVER .img-scale-bottom{
	-moz-transform: scale(1.4);
	-o-transform: scale(1.4);
	-webkit-transform: scale(1.4);
	transform: scale(1.4);
}            

div#'.$id.' .nextend-smartslider-caption:HOVER .caption.nextend-smartslider-caption-scale-bottom{
	bottom: 0;
}';

            case 'scale-top':
                return
'div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-scale-top{
	top: -100%;
}    

div#'.$id.' .nextend-smartslider-caption:HOVER .img-scale-top{
	-moz-transform: scale(1.4);
	-o-transform: scale(1.4);
	-webkit-transform: scale(1.4);
	transform: scale(1.4);
}            

div#'.$id.' .nextend-smartslider-caption:HOVER .caption.nextend-smartslider-caption-scale-top{
	top: 0;
}';

            case 'fade':
                return
'div#'.$id.' .nextend-smartslider-caption .caption.nextend-smartslider-caption-fade{
                  opacity: 0;
                }
                
                div#'.$id.' .nextend-smartslider-caption:HOVER .caption.nextend-smartslider-caption-fade{
                  opacity: 1;
                }';
        }
    }

    function getValues() {
        return array(
            'image' => NextendSmartSliderSettings::get('placeholder'),
            'alt' => 'Image not available',
            'link' => '#|*|_self',
            'size' => '130|*|130',
            'content' => 'Title',
            'description' => 'Here comes the description text.',
            'captionclass' => 'simple-bottom',
            'fontclasstitle' => 'sliderfont1',
            'fontclass' => 'sliderfont11',
            'color' => '00000080',
            'customcaptionclass' => '',
            'onmouseclick' => '',
            'onmouseenter' => '',
            'onmouseleave' => ''
        );
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . $this->_identifier . DIRECTORY_SEPARATOR;
    }
}

NextendPlugin::addPlugin('nextendslideritem', 'plgNextendSliderItemCaption');