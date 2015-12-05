<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php
nextendimportsmartslider2('nextend.smartslider.settings');

class plgNextendSliderGeneratorFlickr extends NextendPluginBase {
    public static $_group = 'flickr';

    function onNextendSliderGeneratorList(&$group, &$list, $showall = false) {
        $group[self::$_group] = 'Flickr';

        if (!isset($list[self::$_group])) $list[self::$_group] = array();
	
	      $configured = is_string(NextendSmartSliderStorage::get(self::$_group));
	
        $list[self::$_group][self::$_group . '_peoplephotostream'] = array(NextendText::_('My_photostream'), $this->getPath() . 'peoplephotostream' . DIRECTORY_SEPARATOR, $configured, true, true, 'image_extended');
        $list[self::$_group][self::$_group . '_peoplephotoset'] = array(NextendText::_('My_photoset'), $this->getPath() . 'peoplephotoset' . DIRECTORY_SEPARATOR, $configured, true, true, 'image_extended');
        $list[self::$_group][self::$_group . '_peoplephotogallery'] = array(NextendText::_('My_gallery'), $this->getPath() . 'peoplephotogallery' . DIRECTORY_SEPARATOR, $configured, true, true, 'image_extended');
    }

    function onNextendFlickr(&$flickr) {
        $config = new NextendData();
        $config->loadJson(NextendSmartSliderStorage::get(self::$_group));
        
        require_once(dirname(__FILE__) . "/api/phpFlickr.php");
        $flickr = new phpFlickr($config->get('apikey', ''), $config->get('apisecret', ''));
        $flickr->setToken($config->get('token', ''));
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR;
    }
    
    function onNextendGeneratorConfigurationList(&$list){
        $list[] = array('id' => self::$_group, 'title' => NextendText::_('Flickr generator'));
    }
    
    function onNextendGeneratorConfiguration(&$group, &$path){
        if($group == self::$_group){
            $path = $this->getPath();
        }
    }
}

/**
 * @return phpFlickr
 */
function getNextendFlickr() {

    $flickr = null;
    NextendPlugin::callPlugin('nextendslidergenerator', 'onNextendFlickr', array(&$flickr));
    
    if ($flickr->auth_checkToken() === false) {
        if (NextendSmartSliderSettings::get('debugmessages', 1)) {
            global $smartslidercontroller;
            echo "<span style='line-height: 24px; padding: 0 10px;'>";
            echo NextendText::_('There_are_some_configuration_issues_with_Flickr_API_Please_check_the_settings').' <a href="' . $smartslidercontroller->route('controller=settings&view=sliders_settings&action=flickr') . '">'.NextendText::_('settings').'</a>!<br />';
            echo "</span>";
        }
        return false;
    }
    return $flickr;
}

NextendPlugin::addPlugin('nextendslidergenerator', 'plgNextendSliderGeneratorFlickr');