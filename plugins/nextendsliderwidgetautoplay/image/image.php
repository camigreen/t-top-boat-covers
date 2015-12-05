<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.widget');

class plgNextendSliderWidgetAutoplayImage extends plgNextendSliderWidgetAbstract {

    var $_name = 'image';

    function onNextendAutoplayList(&$list) {
        $list[$this->_name] = $this->getPath();
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR;
    }

    static function render($slider, $id, $params) {

        $html = '';   
        
        $autoplayimage = $params->get('autoplayimage', false);
        if($autoplayimage && $autoplayimage != -1){

            $displayclass = self::getDisplayClass($params->get('widgetautoplaydisplay', '0|*|always|*|0|*|0'), true);

            $css = NextendCss::getInstance();
            $css->addCssFile(NextendFilesystem::translateToMediaPath(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR.'style.css'));

            list($style, $data) = self::getPosition($params->get('autoplayimageposition', ''));

            $info = pathinfo($autoplayimage);
            $class = 'nextend-autoplay-button nextend-autoplay-image nextend-autoplay-'.basename($autoplayimage, '.'.$info['extension']);
            $html.= '<div onclick="njQuery(this).hasClass(\'paused\') ? njQuery(\'#'.$id.'\').smartslider(\'startautoplay\') : njQuery(\'#'.$id.'\').smartslider(\'pauseautoplay\');" class="'.$displayclass.$class.'" style="'.$style.'" '.$data.'></div>';
        }

        return $html;
    }

}
NextendPlugin::addPlugin('nextendsliderwidgetautoplay', 'plgNextendSliderWidgetAutoplayImage');