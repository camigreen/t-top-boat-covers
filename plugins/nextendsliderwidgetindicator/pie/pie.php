<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.widget');
nextendimport('nextend.image.color');

class plgNextendSliderWidgetIndicatorPie extends plgNextendSliderWidgetAbstract {

    var $_name = 'pie';

    function onNextendIndicatorList(&$list) {
        $list[$this->_name] = $this->getPath();
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'pie' . DIRECTORY_SEPARATOR;
    }

    static function render($slider, $id, $params) {

        $html = '';
        
        $indicatorskin = $params->get('indicatorskin', false);

        if($indicatorskin && $indicatorskin != -1){
        
            $displayclass = self::getDisplayClass($params->get('widgetindicatordisplay', '0|*|always|*|0|*|0'), true).'nextend-indicator ';

            $js = NextendJavascript::getInstance();
            $js->addLibraryJsFile('jquery', dirname(__FILE__) . '/pie/jquery.knob.js');

            list($style, $data) = self::getPosition($params->get('indicatorposition', ''));

            $style.= 'z-index:10;';

            $size = intval($params->get('indicatorsize', 50));
            $color = NextendParse::parse($params->get('indicatorcolor', 50));
            
            list($color[0], $rgbafg) = NextendColor::colorToCss($color[0]);
            list($color[1], $rgbabg) = NextendColor::colorToCss($color[1]);

            $html='<div class="'.$displayclass.'nextend-indicator-pie" style="line-height:0;'.$style.'" '.$data.'>
                    <input class="nextend-indicator-pie-input" name="pie" type="hidden" value="0"
                    data-thickness="'.$params->get('indicatorthickness', 0.5).'"
                    data-width="'.$size.'"
                    data-height="'.$size.'"
                    data-linecap="'.$params->get('indicatorlinecap', 'butt').'"
                    data-fgcolor="'.$rgbafg.'"
                    data-bgcolor="'.$rgbabg.'"
                    data-readOnly="1" autocomplete="off" />
                </div>';

            $skin = '';

            switch(basename($params->get('indicatorskin', 'default.png'))){
                case 'tron.png':
                    $skin = 'draw : function () {
                        var a = this.angle(this.cv)  // Angle
                            , sa = this.startAngle          // Previous start angle
                            , sat = this.startAngle         // Start angle
                            , ea                            // Previous end angle
                            , eat = sat + a                 // End angle
                            , r = true;

                        this.g.lineWidth = this.lineWidth;

                        this.o.cursor
                            && (sat = eat - 0.3)
                            && (eat = eat + 0.3);

                        if (this.o.displayPrevious) {
                            ea = this.startAngle + this.angle(this.value);
                            this.o.cursor
                                && (sa = ea - 0.3)
                                && (ea = ea + 0.3);
                            this.g.beginPath();
                            this.g.strokeStyle = this.previousColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                            this.g.stroke();
                        }

                        this.g.beginPath();
                        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor ;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                        this.g.stroke();

                        this.g.lineWidth = 2;
                        this.g.beginPath();
                        this.g.strokeStyle = this.o.fgColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                        this.g.stroke();

                        return false;
                    }';
                    break;
            }


            $html .="
              <script type='text/javascript'>
                  function isCanvasSupported(){
                    var elem = document.createElement('canvas');
                    return !!(elem.getContext && elem.getContext('2d'));
                  }
                  njQuery(document).ready(function () {
                     if(isCanvasSupported()){
                         var input = window.njQuery('#".$id." .nextend-indicator-pie-input');
                         input.knob({
                            ".$skin."
                         });
                         window['".$id."-indicator'] = {
                            hide: function(){
                                input.hide();
                            },
                            show: function(){
                                input.show();
                            },
                            refresh: function(val){
                                input.val(val).trigger('change');
                            }
                         };
                     }
                  });
              </script>
            ";
            
        }

        return $html;
    }
}

NextendPlugin::addPlugin('nextendsliderwidgetindicator', 'plgNextendSliderWidgetIndicatorPie');
