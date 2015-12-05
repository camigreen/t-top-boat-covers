<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.widget');
nextendimport('nextend.image.color');

class plgNextendSliderWidgetArrowText extends plgNextendSliderWidgetAbstract {

    var $_name = 'text';

    function onNextendarrowList(&$list) {
        $list[$this->_name] = $this->getPath();
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'text' . DIRECTORY_SEPARATOR;
    }

    static function render($slider, $id, $params) {

        $html = '';

        $previous = $params->get('previous', false);

        $next = $params->get('next', false);

        $enabled = ($previous && $previous != -1) || ($next && $next != -1);
        
        $fontsize = intval($slider->_sliderParams->get('globalfontsize', '12'));

        if ($enabled) {

            $displayclass = self::getDisplayClass($params->get('widgetarrowdisplay', '0|*|always|*|0|*|0'), true);

            list($colorhex, $rgbacss) = NextendColor::colorToCss($params->get('arrowtextbackground', '00ff00ff'));
            list($colorhexhover, $rgbacsshover) = NextendColor::colorToCss($params->get('arrowtextbackgroundhover', '000000ff'));
            
            $css = NextendCss::getInstance();
            $css->addCssFile(NextendFilesystem::translateToMediaPath(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'text' . DIRECTORY_SEPARATOR . 'style.css'));

            if ($previous && $previous != -1) {
                
                list($style, $data) = self::getPosition($params->get('previousposition', ''));
                
                $style .= 'font-size: '.$fontsize.'px;';
                
                $info = pathinfo($previous);
                $class = 'nextend-arrow-previous nextend-arrow-text nextend-arrow-text-previous nextend-arrow-text-previous-' . basename($previous, '.' . $info['extension']);
                $html .= '<div onclick="njQuery(\'#' . $id . '\').smartslider(\'previous\');" class="' . $displayclass . $class . '" style="' . $style . '" '.$data.'>
                            <span class="' . $params->get('fontclassprev', 'sliderfont7') . '">' . $params->get('contentprev', 'Prev') . '</span>
                          </div>';
            }

            if ($next && $next != -1) {
                
                list($style, $data) = self::getPosition($params->get('nextposition', ''));

                $style .= 'font-size: '.$fontsize.'px;';
                
                $info = pathinfo($next);
                $class = 'nextend-arrow-next nextend-arrow-text nextend-arrow-text-next nextend-arrow-text-next-' . basename($next, '.' . $info['extension']);
                $html .= '<div onclick="njQuery(\'#' . $id . '\').smartslider(\'next\');" class="' . $displayclass . $class . '" style="' . $style . '" '.$data.'>
                            <span class="' . $params->get('fontclassnext', 'sliderfont7') . '">' . $params->get('contentnext', 'Next') . '</span>
                          </div>';
            }
            
            $css->addCssFile('
                #'.$id.' .nextend-arrow-text-next,
                #'.$id.' .nextend-arrow-text-previous{
                    background-color:' . $rgbacss . ';
                }
                #'.$id.' .nextend-arrow-text-next:HOVER,
                #'.$id.' .nextend-arrow-text-previous:HOVER{
                    background-color:' . $rgbacsshover . ';
                }', $id);
        }

        return $html;
    }

}
NextendPlugin::addPlugin('nextendsliderwidgetarrow', 'plgNextendSliderWidgetArrowText');