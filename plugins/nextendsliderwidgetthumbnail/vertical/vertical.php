<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.plugin.widget');
nextendimport('nextend.image.color');

class plgNextendSliderWidgetThumbnailVertical extends plgNextendSliderWidgetAbstract {

    var $_name = 'vertical';

    function onNextendthumbnailList(&$list) {
        $list[$this->_name] = $this->getPath();
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vertical' . DIRECTORY_SEPARATOR;
    }

    static function render($slider, $id, $params) {

        $html = '';
        $thumbnail = $params->get('thumbnail', false);
        if ($thumbnail && $thumbnail != '-1') {

            $displayclass = self::getDisplayClass($params->get('widgetthumbnaildisplay', '0|*|always|*|0|*|0'), true);

            $css = NextendCss::getInstance();
            $css->addCssFile(NextendFilesystem::translateToMediaPath(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vertical' . DIRECTORY_SEPARATOR . 'style.css'));

            $js = NextendJavascript::getInstance();
            $js->addLibraryJsLibraryFile('jquery', 'jquery.mousewheel.js');
            $js->addLibraryJsFile('jquery', dirname(__FILE__) . '/vertical/script.js');

            $thumbnailactivebackground = $params->get('thumbnailactivebackground', '00000080');
            $rgbathumbnailactivebackground = NextendColor::hex2rgba($thumbnailactivebackground);
            $rgbacssthumbnailactivebackground = 'RGBA('.$rgbathumbnailactivebackground[0].','.$rgbathumbnailactivebackground[1].','.$rgbathumbnailactivebackground[2].','.round($rgbathumbnailactivebackground[3]/127, 2).')';
            $colorhexthumbnailactivebackground = substr($thumbnailactivebackground, 0,6);

            $info = pathinfo($thumbnail);
            $class = 'nextend-thumbnail nextend-thumbnail-vertical nextend-thumbnail-vertical-' . basename($thumbnail, '.' . $info['extension']);

            $thumbnailcolumn = $params->get('thumbnailcolumn', '30');
            $thumbnailperpage = $params->get('thumbnailperpage', 2);

            list($positionstyle, $data) = self::getPosition($params->get('thumbnailposition', ''));
            $positionstyle.= 'z-index:10; font-size: '.intval($slider->_sliderParams->get('globalfontsize', '12')).'px;';


            $thumbnailgalleryoutersize = NextendParse::parse($params->get('thumbnailgalleryoutersize', '30%|*|100%'));

            if (is_numeric($thumbnailgalleryoutersize[0]) || $thumbnailgalleryoutersize[0] == 'auto' || substr($thumbnailgalleryoutersize[0], -1) == '%') {
                $positionstyle .= 'width:' . $thumbnailgalleryoutersize[0] . ';';
            } else {
                $data.= ' data-sswidth="'.$thumbnailgalleryoutersize[0].'"';
            }

            if (is_numeric($thumbnailgalleryoutersize[1]) || $thumbnailgalleryoutersize[1] == 'auto' || substr($thumbnailgalleryoutersize[1], -1) == '%') {
                $positionstyle .= 'height:' . $thumbnailgalleryoutersize[1] . ';';
            } else {
                $data.= ' data-ssheight="'.$thumbnailgalleryoutersize[1].'"';
            }

            $html .= '<div id="'.$id.'-thumbnail" class="'.$displayclass.'" style="'.$positionstyle.'" '.$data.'>';

            $html .= '<div class="nextend-thumbnail-container ' . $class . ' nextend-clearfix">
            <div class="nextend-arrow-top"></div>';

            $html .= '<div class="nextend-thumbnail-strip-hider"><div class="nextend-thumbnail-strip">';
            
            $thumbnailtitlelink = $params->get('thumbnailtitlelink', 0);

            for ($i = 0; $i < count($slider->_slides); $i++) {
                $html .= '<div onclick="njQuery(\'#' . $id . '\').smartslider(\'goto\',' . $i . ',false);" class="' . $class . ($slider->_slides[$i]['first'] ? ' active' : '') . '">';
                if($thumbnailcolumn != 0){
                    if(!$slider->_slides[$i]['thumbnail'] && $slider->_slides[$i]['bg']['desktop']){
                        $slider->_slides[$i]['thumbnail'] = $slider->_slides[$i]['bg']['desktop'];
                    }
                    $html .= '<div class="nextend-thumbnail-vertical-image" style="float:left;width:'.$thumbnailcolumn.'%; background-image:url(\''.$slider->_slides[$i]['thumbnail'].'\');"></div>';
                }
                $html .= '<div class="nextend-thumbnail-vertical-content" style="width:'.(100-$thumbnailcolumn).'%;">';
                
                $link = NextendParse::parse($slider->_slides[$i]['params']->get('link'));
                    
                if($thumbnailtitlelink && $link[0] != '' && $link[0] != '#'){
                    $html .= '<h4 class="'.$params->get('thumbnailfontclasstitle').'"><a href="'.$link[0].'" target="'.$link[1].'">'.$slider->_slides[$i]['title'].'</a></h4>';
                }else{
                    $html .= '<h4 class="'.$params->get('thumbnailfontclasstitle').'">'.$slider->_slides[$i]['title'].'</h4>';
                }
                
                
                if($params->get('thumbnailshowdescription', 1)){
                    $html .= '<p class="'.$params->get('thumbnailfontclassdescription').'">'.$slider->_slides[$i]['description'].'</p>';
                }
                
                $html .= '</div></div>';
            }

            $html .= '</div></div>';

            $html .= '<div class="nextend-arrow-bottom"></div></div></div>';

            $html .="
              <script type='text/javascript'>
                  njQuery(document).ready(function () {
                      window['".$id."-thumbnail'] = new smartSliderVertical({
                          id: '".$id."',
                          node: window.njQuery('#".$id."-thumbnail'),
                          thumbnailperpage: '".$thumbnailperpage."',
                          thumbnailanimation: '".$params->get('thumbnailanimation', 700)."'
                      });
                  });
              </script>
            ";
            
            $css->addCssFile('
                #'.$id.' .nextend-thumbnail-container .nextend-thumbnail-vertical-vertical1:HOVER,            
                #'.$id.' .nextend-thumbnail-container .nextend-thumbnail-vertical-vertical1.active,                      
                #'.$id.' .nextend-thumbnail-container.nextend-thumbnail-vertical-vertical1 .nextend-arrow-top:HOVER,
                #'.$id.' .nextend-thumbnail-container.nextend-thumbnail-vertical-vertical1 .nextend-arrow-bottom:HOVER,
                #'.$id.' .nextend-thumbnail-container .nextend-thumbnail-vertical-vertical-light:HOVER,            
                #'.$id.' .nextend-thumbnail-container .nextend-thumbnail-vertical-vertical-light.active,                      
                #'.$id.' .nextend-thumbnail-container.nextend-thumbnail-vertical-vertical-light .nextend-arrow-top:HOVER,
                #'.$id.' .nextend-thumbnail-container.nextend-thumbnail-vertical-vertical-light .nextend-arrow-bottom:HOVER{            
                    background-color:'.$rgbacssthumbnailactivebackground.';
                }', $id);
        }
        return $html;
    }

}
NextendPlugin::addPlugin('nextendsliderwidgetthumbnail', 'plgNextendSliderWidgetThumbnailVertical');