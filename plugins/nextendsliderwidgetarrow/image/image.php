<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.widget');

class plgNextendSliderWidgetArrowImage extends plgNextendSliderWidgetAbstract {

    var $_name = 'image';

    function onNextendarrowList(&$list) {
        $list[$this->_name] = $this->getPath();
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR;
    }

    static function render($slider, $id, $params) {
        $html = '';

        $previous = $params->get('previous', false);
        $next = $params->get('next', false);
        $enabled = ($previous && $previous != -1) || ($next && $next != -1);

        if ($enabled) {

            $displayclass = self::getDisplayClass($params->get('widgetarrowdisplay', '0|*|always|*|0|*|0'), true);

            $css = NextendCss::getInstance();
            $css->addCssFile(NextendFilesystem::translateToMediaPath(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR . 'style.css'));

            if ($previous && $previous != -1) {
            
                list($style, $data) = self::getPosition($params->get('previousposition', ''));

                $info = pathinfo($previous);
                $class = 'nextend-arrow-previous nextend-image nextend-image-previous nextend-image-previous-' . basename($previous, '.' . $info['extension']);
                $html .= '<div onclick="njQuery(\'#' . $id . '\').smartslider(\'previous\');" class="' . $displayclass . $class . '" style="' . $style . '" '.$data.'></div>';
            }

            if ($next && $next != -1) {
            
                list($style, $data) = self::getPosition($params->get('nextposition', ''));
                
                $info = pathinfo($next);
                $class = 'nextend-arrow-next nextend-image nextend-image-next nextend-image-next-' . basename($next, '.' . $info['extension']);
                $html .= '<div onclick="njQuery(\'#' . $id . '\').smartslider(\'next\');" class="' . $displayclass . $class . '" style="' . $style . '" '.$data.'></div>';
            }
        }

        return $html;
    }

}

NextendPlugin::addPlugin('nextendsliderwidgetarrow', 'plgNextendSliderWidgetArrowImage');