<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.widget');
nextendimport('nextend.image.color');

class plgNextendSliderWidgetIndicatorStripe extends plgNextendSliderWidgetAbstract {

    var $_name = 'stripe';

    function onNextendIndicatorList(&$list) {
        $list[$this->_name] = $this->getPath();
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'stripe' . DIRECTORY_SEPARATOR;
    }

    static function render($slider, $id, $params) {

        $html = '';

        $indicatorstripe = $params->get('indicatorstripe', false);

        if ($indicatorstripe && $indicatorstripe != -1) {
        
            $displayclass = self::getDisplayClass($params->get('widgetindicatordisplay', '0|*|always|*|0|*|0'), true).'nextend-indicator ';

            $css = NextendCss::getInstance();
            $css->addCssFile(NextendFilesystem::translateToMediaPath(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'stripe' . DIRECTORY_SEPARATOR . 'style.css'));
            
            list($style, $data) = self::getPosition($params->get('indicatorposition', ''));
            
            $style.= 'z-index:10;';
            
            $width = NextendParse::parse($params->get('indicatorwidth', '100%'));
            if(is_numeric($width) || $width == 'auto' || substr($width, -1) == '%'){
                $style.= 'width:'.$width.';';
            }else{
                $data.= 'data-sswidth="'.$width.'" ';
            }

            $size = intval($params->get('indicatorsize', 50));

            list($colorhex, $rgbacss) = NextendColor::colorToCss($params->get('indicatorstripecolor', '000000cc'));
            list($colorhexbg, $rgbacssbg) = NextendColor::colorToCss($params->get('backgroundstripecolor', '7670c7ff'));
            
            $height = $params->get('indicatorstripeheight', '6');

            $info = pathinfo($indicatorstripe);
            $class = 'nextend-indicator nextend-indicator-stripe nextend-indicator-stripe-' . basename($indicatorstripe, '.' . $info['extension']);

            $html = '<div class="'.$displayclass.'nextend-indicator-stripe-container" style="' . $style . 'background-color:'.$colorhexbg.'; background-color:'.$rgbacssbg.'; height: '.$height.'px;" '.$data.'><div class="'.$class.'" style="width: 0%; background-color:'.$colorhex.'; background-color:'.$rgbacss.'; height: '.$height.'px;"></div></div>';



            $html .="
              <script type='text/javascript'>
                  njQuery(document).ready(function () {
                      var stripe = window.njQuery('#" . $id . " .nextend-indicator-stripe');
                       window['" . $id . "-indicator'] = {
                          hide: function(){
                              stripe.hide();
                          },
                          show: function(){
                              stripe.show();
                          },
                          refresh: function(val){
                              stripe.css('width', val+'%');
                          }
                       };
                  });
              </script>
            ";
            
        }

        return $html;
    }
}

NextendPlugin::addPlugin('nextendsliderwidgetindicator', 'plgNextendSliderWidgetIndicatorStripe');
