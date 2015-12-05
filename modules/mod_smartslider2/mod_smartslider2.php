<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php
jimport('nextend.library');

defined('NEXTEND_SMART_SLIDER2_ASSETS') || define('NEXTEND_SMART_SLIDER2_ASSETS', NEXTENDLIBRARY . 'assets' . DIRECTORY_SEPARATOR . 'smartslider' . DIRECTORY_SEPARATOR );

nextendimport('nextend.smartslider.slidercache');
nextendimport('nextend.smartslider.joomla.slider');

new NextendSliderCache(new NextendSliderJoomla($module, $params, dirname(__FILE__)));

/*
 * Joomla cache fix!
 *//*
$config = JFactory::getConfig();
$caching = $config->get( 'config.caching' );
if($caching === NULL) $caching = $config->get( 'caching' );
$app = JFactory::getApplication();
if($app->isSite() && ($caching == 2 || $caching == 1)){
    if(class_exists('NextendCss', false)){
        $css = NextendCss::getInstance();
        $css->generateCSS();
    }
    if(class_exists('NextendJavascript', false)){
        $js = NextendJavascript::getInstance();
        $js->generateJs();
    }
}*/