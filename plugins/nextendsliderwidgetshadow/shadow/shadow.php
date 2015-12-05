<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.widget');

class plgNextendSliderWidgetShadowShadow extends plgNextendSliderWidgetAbstract {

    var $_name = 'shadow';

    function onNextendshadowList(&$list) {
        $list[$this->_name] = $this->getPath();
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'shadow' . DIRECTORY_SEPARATOR;
    }

    static function render($slider, $id, $params) {

        $html = '';

        $shadowcss = $params->get('shadowcss', false);        

        if($shadowcss && $shadowcss != -1){
        
            $displayclass = self::getDisplayClass($params->get('widgetshadowdisplay', '0|*|always|*|0|*|0'), false);
            
            list($style, $data) = self::getPosition($params->get('shadowposition', ''));
            
            $width = NextendParse::parse($params->get('shadowwidth', 'width'));
            if(is_numeric($width) || $width == 'auto' || substr($width, -1) == '%'){
                $style.= 'width:'.$width.';';
            }else{
                $data.= 'data-sswidth="'.$width.'" ';
            }

            $css = NextendCss::getInstance();
            $css->addCssFile(NextendFilesystem::translateToMediaPath(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'shadow' . DIRECTORY_SEPARATOR.'style.css'));

            $info = pathinfo($shadowcss);
            $class = 'nextend-shadow nextend-shadow-'.basename($shadowcss, '.'.$info['extension']);
            $html.= '<div class="'.$displayclass.$class.'" style="line-height:0;'.$style.'" '.$data.'><img src="'.(nextendIsWordpress() ? plugins_url('shadow/shadow/'.$info['basename'], __FILE__) : NextendUri::pathToUri(NextendFilesystem::getBasePath().$shadowcss)).'"/></div>';
        }

        return $html;
    }
}

NextendPlugin::addPlugin('nextendsliderwidgetshadow', 'plgNextendSliderWidgetShadowShadow');
