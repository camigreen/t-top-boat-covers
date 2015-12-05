<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.widget');

class plgNextendSliderWidgetBarGradient extends plgNextendSliderWidgetAbstract {

    var $_name = 'gradient';

    function onNextendBarList(&$list) {
        $list[$this->_name] = $this->getPath();
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'gradient' . DIRECTORY_SEPARATOR;
    }

    static function render($slider, $id, $params) {

        $html = '';

        $bargradient = $params->get('bargradient', false);
        if ($bargradient && $bargradient != -1) {

            $displayclass = self::getDisplayClass($params->get('widgetbardisplay', '0|*|always|*|0|*|0'), true);

            $css = NextendCss::getInstance();
            $css->enableLess();
            $cssfile = NextendFilesystem::translateToMediaPath(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'gradient' . DIRECTORY_SEPARATOR . 'style.less');
            $css->addCssFile(array(
                $cssfile,
                $cssfile,
                array('id' => '~"#' . $id . '"')
            ), $id);
            
            list($style, $data) = self::getPosition($params->get('bargradientposition', ''));
            
            $width = NextendParse::parse($params->get('bargradientwidth', '100%'));
            if(is_numeric($width) || $width == 'auto' || substr($width, -1) == '%'){
                $style.= 'width:'.$width.';';
            }else{
                $data.= 'data-sswidth="'.$width.'" ';
            }

            $height = $params->get('bargradientheight', '30');
            $style .= 'height: ' . $height . 'px;';
            $style .= 'font-size: '.intval($slider->_sliderParams->get('globalfontsize', '12')).'px;';

            $info = pathinfo($bargradient);
            $class = 'nextend-bar nextend-bar-g nextend-bar-g-' . basename($bargradient, '.' . $info['extension']);
            $html .= '<div class="' . $displayclass . $class . '" style="' . $style . '" '.$data.'>';
            $html .= '<div class="inner" style="height:' . ($height - 2) . 'px;">';

            for ($i = 0; $i < count($slider->_slides); $i++) {
                $html .= '<div class="nextend-bar-slide ' . ($slider->_slides[$i]['first'] ? ' active' : '') . '">';
                $html .= '<h6 class="' . $params->get('bargradienttitlefont', '') . '" style="line-height: ' . $height . 'px;">' . $slider->_slides[$i]['title'] . '</h6>';
                if ($slider->_slides[$i]['description']) {
                    $html .= '<p class="' . $params->get('bargradientdescriptionfont', '') . '" style="line-height: ' . $height . 'px;"> - ' . $slider->_slides[$i]['description'] . '</p>';
                }
                $html .= '</div>';
            }

            $html .= '</div></div>';
        }

        return $html;
    }

}
NextendPlugin::addPlugin('nextendsliderwidgetbar', 'plgNextendSliderWidgetBarGradient');