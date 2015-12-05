<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.widget');
nextendimport('nextend.image.color');

class plgNextendSliderWidgetBarVertical extends plgNextendSliderWidgetAbstract {

    var $_name = 'vertical';

    function onNextendBarList(&$list) {
        $list[$this->_name] = $this->getPath();
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vertical' . DIRECTORY_SEPARATOR;
    }

    static function render($slider, $id, $params) {

        $html = '';
        
        $barvertical = $params->get('barvertical', false);
        if($barvertical && $barvertical != -1){

            $displayclass = self::getDisplayClass($params->get('widgetbardisplay', '0|*|always|*|0|*|0'), true);
        
            list($colorhex, $rgbacss) = NextendColor::colorToCss($params->get('barbackground', '00000080'));

            $css = NextendCss::getInstance();
            $css->enableLess();
            $cssfile = NextendFilesystem::translateToMediaPath(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vertical' . DIRECTORY_SEPARATOR . 'style.less');
            $css->addCssFile(array(
                $cssfile,
                $cssfile,
                array('id' => '~"#' . $id . '"')
            ), $id);

            list($style, $data) = self::getPosition($params->get('barverticalposition', ''));

            $style.= 'background-color:'.$rgbacss.';';
            
            $width = NextendParse::parse($params->get('barverticalwidth', '30'));
            if(is_numeric($width)){
                $style.= 'width:'.$width.'%;';
            }else{
                $data.= 'data-sswidth="'.$width.'" ';
            }
            
            $height = NextendParse::parse($params->get('barverticalheight', '100'));
            if(is_numeric($height)){
                $style.= 'height:'.$height.'%;';
            }else{
                $data.= 'data-ssheight="'.$height.'" ';
            }
            
            $style .= 'font-size: '.intval($slider->_sliderParams->get('globalfontsize', '12')).'px;';

            $info = pathinfo($barvertical);
            $class = 'nextend-bar nextend-bar-v nextend-bar-v-'.basename($barvertical, '.'.$info['extension']);
            $html.= '<div class="'.$displayclass.$class.'" style="'.$style.'" '.$data.'>';

            for ($i = 0; $i < count($slider->_slides); $i++) {
                $html.= '<div class="nextend-bar-slide '.($slider->_slides[$i]['first'] ? ' active' : '').'">';
                $html.= '<h6 class="'.$params->get('barverticaltitlefont','').'">'.$slider->_slides[$i]['title'].'</h6>';
                if($slider->_slides[$i]['description']){
                  $html.= '<p class="'.$params->get('barverticaldescriptionfont','').'">'.$slider->_slides[$i]['description'].'</p>';
                }
                $html.= '<div style="clear: both;"></div></div>';
            }

            $html.= '</div>';
        }

        return $html;
    }

}
NextendPlugin::addPlugin('nextendsliderwidgetbar', 'plgNextendSliderWidgetBarVertical');