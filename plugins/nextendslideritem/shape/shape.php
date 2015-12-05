<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.slideritem');

class plgNextendSliderItemShape extends plgNextendSliderItemAbstract {

    var $_identifier = 'shape';

    var $_title = 'Shape';

    function getTemplate() {
        return '
          <div>
        		<div id="{{uuid}}" class="{uuuid} nextend-smartslider-shape nextend-smartslider-shape-{shapeclass}"></div>
            <style>   
               div#{{id}} .{uuuid}.nextend-smartslider-shape-square{
                width: {width}px;
                height: {height}px;
                background: #{colorhex};
                background: RGBA({colora});
               }   
               
               div#{{id}} .{uuuid}.nextend-smartslider-shape-rounded-square{
                width: {width}px;
                height: {height}px;
                background: #{colorhex};
                background: RGBA({colora});                
                -webkit-border-radius: 2%;
                -moz-border-radius: 2%;
                border-radius: 2%;
               }
               
              div#{{id}} .{uuuid}.nextend-smartslider-shape-circle{
                width: {width}px;
                height: {height}px;
                background: #{colorhex};
                background: RGBA({colora});
                -webkit-border-radius: 100%;
                -moz-border-radius: 100%;
                border-radius: 100%;
               }
               
              div#{{id}} .{uuuid}.nextend-smartslider-shape-triangle-up{
                width: 0; 
                height: 0; 
                border-left: {width}px solid transparent; 
                border-right: {width}px solid transparent; 
                border-bottom: {height}px solid #{colorhex};
                border-bottom: {height}px solid RGBA({colora});
               }
               
              div#{{id}} .{uuuid}.nextend-smartslider-shape-triangle-down{
                width: 0; 
                height: 0; 
                border-left: {width}px solid transparent; 
                border-right: {width}px solid transparent; 
                border-top: {height}px solid #{colorhex};
                border-top: {height}px solid RGBA({colora});
               }
               
              div#{{id}} .{uuuid}.nextend-smartslider-shape-triangle-left{
                width: 0; 
                height: 0; 
                border-top: {height}px solid transparent; 
                border-right: {width}px solid #{colorhex};
                border-right: {width}px solid RGBA({colora}); 
                border-bottom: {height}px solid transparent;
               }
               
              div#{{id}} .{uuuid}.nextend-smartslider-shape-triangle-right{
                width: 0; 
                height: 0; 
                border-top: {height}px solid transparent; 
                border-left: {width}px solid #{colorhex};
                border-left: {width}px solid RGBA({colora}); 
                border-bottom: {height}px solid transparent;
               }               
                              
              div#{{id}} .{uuuid}.nextend-smartslider-shape-triangle-top-left{
                width: 0; 
                height: 0;                 
                border-top: {height}px solid #{colorhex};
                border-top: {height}px solid RGBA({colora}); 
                border-right: {width}px solid transparent;
               }  
                            
              div#{{id}} .{uuuid}.nextend-smartslider-shape-triangle-top-right{
                width: 0; 
                height: 0;                 
                border-top: {height}px solid #{colorhex};
                border-top: {height}px solid RGBA({colora}); 
                border-left: {width}px solid transparent;
               }              
               
               div#{{id}} .{uuuid}.nextend-smartslider-shape-triangle-bottom-left{
                width: 0; 
                height: 0;                 
                border-bottom: {height}px solid #{colorhex};
                border-bottom: {height}px solid RGBA({colora}); 
                border-right: {width}px solid transparent;
               }  
                            
              div#{{id}} .{uuuid}.nextend-smartslider-shape-triangle-bottom-right{
                width: 0; 
                height: 0;                 
                border-bottom: {height}px solid #{colorhex};
                border-bottom: {height}px solid RGBA({colora}); 
                border-left: {width}px solid transparent;
               }
            </style>
    
          	<script type=\'text/javascript\'>
          	    if(typeof window.ssitemmarker == \'undefined\' && window[\'{{id}}-onresize\']){
                    (function(){
                        var w = {width},
                          h = {height};
                        var index = window[\'{{id}}-onresize\'].push(function(ratio){
                            var node = njQuery(\'#{{uuid}}\');
                            window.lastratio = ratio;
                            var nw = w*ratio,
                                nh = h*ratio;
                            switch(\'{shapeclass}\'){
                              case \'triangle-up\':
                                node.css({
                                    \'borderLeftWidth\': nw,
                                    \'borderRightWidth\': nw,
                                    \'borderBottomWidth\': nh
                                });
                                break;
                              case \'triangle-down\':
                                node.css({
                                    \'borderLeftWidth\': nw,
                                    \'borderRightWidth\': nw,
                                    \'borderTopWidth\': nh
                                });
                                break;
                              case \'triangle-left\':
                                node.css({
                                    \'borderTopWidth\': nh,
                                    \'borderRightWidth\': nw,
                                    \'borderBottomWidth\': nh
                                });
                                break;
                              case \'triangle-right\':
                                node.css({
                                    \'borderTopWidth\': nh,
                                    \'borderLeftWidth\': nw,
                                    \'borderBottomWidth\': nh
                                });
                                break;
                              case \'triangle-top-left\':
                                node.css({
                                    \'borderTopWidth\': nh,
                                    \'borderRightWidth\': nw
                                });
                                break;
                              case \'triangle-top-right\':
                                node.css({
                                    \'borderLeftWidth\': nw,
                                    \'borderTopWidth\': nh
                                });
                                break;
                              case \'triangle-bottom-left\':
                                node.css({
                                    \'borderBottomWidth\': nh,
                                    \'borderRightWidth\': nw
                                });
                                break;
                              case \'triangle-bottom-right\':
                                node.css({
                                    \'borderLeftWidth\': nw,
                                    \'borderBottomWidth\': nh
                                });
                                break;
                              default:
                                node.width(nw);
                                node.height(nh);
                            }
                        }) - 1;
                        if(window.ssadmin){
                            window[\'{{id}}-onresize\'][index](window.lastratio);
                        }
                    })();
                }
          	</script>
        </div>
        ';
    }
    
    function _renderAdmin($data, $id, $sliderid, $items){
        $shapeclass = $data->get('shapeclass', 'square');
        
        $colors = NextendColor::colorToCss($data->get('color', '00000080'));
        $data->set('colorhex', $colors[0]);
        $data->set('colora', $colors[1]);
        
        $size = (array)NextendParse::parse($data->get('size', ''));
        if(!isset($size[0])) $size[0] = '100';
        if(!isset($size[1])) $size[1] = '100';
        $data->set('width', $size[0]);
        $data->set('height', $size[1]);

        return 
'<div>
	<div id="'.$id.'" class="'.$id.' nextend-smartslider-shape nextend-smartslider-shape-'.$shapeclass.'"></div>
  <style>'.$this->getCss($shapeclass, $id, $sliderid, $data).'</style>
  <script type="text/javascript">'.$this->getJs($shapeclass, $id, $sliderid, $data).'</script>
</div>';
    }
    
    function _render($data, $id, $sliderid, $items){
        $shapeclass = $data->get('shapeclass', 'square');
        
        $colors = NextendColor::colorToCss($data->get('color', '00000080'));
        $data->set('colorhex', $colors[0]);
        $data->set('colora', $colors[1]);
        
        $size = (array)NextendParse::parse($data->get('size', ''));
        if(!isset($size[0])) $size[0] = '100';
        if(!isset($size[1])) $size[1] = '100';
        $data->set('width', $size[0]);
        $data->set('height', $size[1]);
             
        $attr = '';
        $click = $data->get('onmouseclick', '');
        if(!empty($click)) $attr.= ' data-click="'.htmlspecialchars($click).'"';
        $enter = $data->get('onmouseenter', '');
        if(!empty($enter)) $attr.= ' data-enter="'.htmlspecialchars($enter).'"';
        $leave = $data->get('onmouseleave', '');
        if(!empty($leave)) $attr.= ' data-leave="'.htmlspecialchars($leave).'"';

        return 
'<div>
	<div id="'.$id.'" class="'.$id.' nextend-smartslider-shape nextend-smartslider-shape-'.$shapeclass.'" '.$attr.'></div>
  <style>'.$this->getCss($shapeclass, $id, $sliderid, $data).'</style>
  <script type="text/javascript">'.$this->getJs($shapeclass, $id, $sliderid, $data).'</script>
</div>';
    }
    
    function getJs($type, $id, $sliderid, $data){
        return 
'if(typeof window.ssitemmarker == "undefined" && window["{{id}}-onresize"]){
  (function(){
      var w = '.$data->get('width').',
        h = '.$data->get('height').';
      var index = window["'.$sliderid.'-onresize"].push(function(ratio){
          var node = njQuery("#'.$id.'");
          window.lastratio = ratio;
          var nw = w*ratio,
              nh = h*ratio;'.$this->_getJs($type, $id, $sliderid, $data).'
        }) - 1;
        if(window.ssadmin){
            window["{{id}}-onresize"][index](window.lastratio);
        }
    })();
}';
    }
    
    function _getJs($type, $id, $sliderid, $data){
        switch($type){
            case 'triangle-up':
                return 
'node.css({
"borderLeftWidth": nw,
"borderRightWidth": nw,
"borderBottomWidth": nh
});';
            case 'triangle-down':
                return 
'node.css({
"borderLeftWidth": nw,
"borderRightWidth": nw,
"borderTopWidth": nh
});';
            case 'triangle-left':
                return 
'node.css({
"borderTopWidth": nh,
"borderRightWidth": nw,
"borderBottomWidth": nh
});';
            case 'triangle-right':
                return 
'node.css({
"borderTopWidth": nh,
"borderLeftWidth": nw,
"borderBottomWidth": nh
});';
            case 'triangle-top-left':
                return 
'node.css({
"borderTopWidth": nh,
"borderRightWidth": nw
});';
            case 'triangle-top-right':
                return 
'node.css({
"borderLeftWidth": nw,
"borderTopWidth": nh
});';
            case 'triangle-bottom-left':
                return 
'node.css({
"borderBottomWidth": nh,
"borderRightWidth": nw
});';
            case 'triangle-bottom-right':
                return 
'node.css({
"borderLeftWidth": nw,
"borderBottomWidth": nh
});';
            default:
                return 
'node.width(nw);
node.height(nh);';
            
        }
    
    }
    
    function getCss($type, $id, $sliderid, $data){
        switch($type){
            case 'square':
                return 
'div#'.$sliderid.' .'.$id.'.nextend-smartslider-shape-square{
    width: '.$data->get('width').'px;
    height: '.$data->get('height').'px;
    background: #'.$data->get('colorhex').';
    background: '.$data->get('colora').';
}';
            case 'rounded-square':
                return 
'div#'.$sliderid.' .'.$id.'.nextend-smartslider-shape-rounded-square{
    width: '.$data->get('width').'px;
    height: '.$data->get('height').'px;
    background: #'.$data->get('colorhex').';
    background: '.$data->get('colora').';                
    -webkit-border-radius: 2%;
    -moz-border-radius: 2%;
    border-radius: 2%;
}';
            case 'circle':
                return 
'div#'.$sliderid.' .'.$id.'.nextend-smartslider-shape-circle{
    width: '.$data->get('width').'px;
    height: '.$data->get('height').'px;
    background: #'.$data->get('colorhex').';
    background: '.$data->get('colora').';
    -webkit-border-radius: 100%;
    -moz-border-radius: 100%;
    border-radius: 100%;
}';
            case 'triangle-up':
                return 
'div#'.$sliderid.' .'.$id.'.nextend-smartslider-shape-triangle-up{
    width: 0; 
    height: 0; 
    border-left: '.$data->get('width').'px solid transparent; 
    border-right: '.$data->get('width').'px solid transparent; 
    border-bottom: '.$data->get('height').'px solid #'.$data->get('colorhex').';
    border-bottom: '.$data->get('height').'px solid '.$data->get('colora').';
}';
            case 'triangle-down':
                return 
'div#'.$sliderid.' .'.$id.'.nextend-smartslider-shape-triangle-down{
    width: 0; 
    height: 0; 
    border-left: '.$data->get('width').'px solid transparent; 
    border-right: '.$data->get('width').'px solid transparent; 
    border-top: '.$data->get('height').'px solid #'.$data->get('colorhex').';
    border-top: '.$data->get('height').'px solid '.$data->get('colora').';
}';
            case 'triangle-left':
                return 
'div#'.$sliderid.' .'.$id.'.nextend-smartslider-shape-triangle-left{
    width: 0; 
    height: 0; 
    border-top: '.$data->get('height').'px solid transparent; 
    border-right: '.$data->get('width').'px solid #'.$data->get('colorhex').';
    border-right: '.$data->get('width').'px solid '.$data->get('colora').'; 
    border-bottom: '.$data->get('height').'px solid transparent;
}';
            case 'triangle-right':
                return 
'div#'.$sliderid.' .'.$id.'.nextend-smartslider-shape-triangle-right{
    width: 0; 
    height: 0; 
    border-top: '.$data->get('height').'px solid transparent; 
    border-left: '.$data->get('width').'px solid #'.$data->get('colorhex').';
    border-left: '.$data->get('width').'px solid '.$data->get('colora').'; 
    border-bottom: '.$data->get('height').'px solid transparent;
}';
            case 'triangle-top-left':
                return 
'div#'.$sliderid.' .'.$id.'.nextend-smartslider-shape-triangle-top-left{
    width: 0; 
    height: 0;                 
    border-top: '.$data->get('height').'px solid #'.$data->get('colorhex').';
    border-top: '.$data->get('height').'px solid '.$data->get('colora').'; 
    border-right: '.$data->get('width').'px solid transparent;
}';
            case 'triangle-top-right':
                return 
'div#'.$sliderid.' .'.$id.'.nextend-smartslider-shape-triangle-top-right{
    width: 0; 
    height: 0;                 
    border-top: '.$data->get('height').'px solid #'.$data->get('colorhex').';
    border-top: '.$data->get('height').'px solid '.$data->get('colora').'; 
    border-left: '.$data->get('width').'px solid transparent;
}';
            case 'triangle-bottom-left':
                return 
'div#'.$sliderid.' .'.$id.'.nextend-smartslider-shape-triangle-bottom-left{
    width: 0; 
    height: 0;                 
    border-bottom: '.$data->get('height').'px solid #'.$data->get('colorhex').';
    border-bottom: '.$data->get('height').'px solid '.$data->get('colora').'; 
    border-right: '.$data->get('width').'px solid transparent;
}';
            case 'triangle-bottom-right':
                return 
'div#'.$sliderid.' .'.$id.'.nextend-smartslider-shape-triangle-bottom-right{
    width: 0; 
    height: 0;                 
    border-bottom: '.$data->get('height').'px solid #'.$data->get('colorhex').';
    border-bottom: '.$data->get('height').'px solid '.$data->get('colora').'; 
    border-left: '.$data->get('width').'px solid transparent;
}';
        }
    
    }

    function getValues() {
        return array(
            'shapeclass' => 'square',
            'size' => '100|*|100',
            'width' => 100,
            'height' => 100,
            'color' => '00000080',
            'onmouseclick' => '',
            'onmouseenter' => '',
            'onmouseleave' => ''
        );
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . $this->_identifier . DIRECTORY_SEPARATOR;
    }
}

NextendPlugin::addPlugin('nextendslideritem', 'plgNextendSliderItemShape');