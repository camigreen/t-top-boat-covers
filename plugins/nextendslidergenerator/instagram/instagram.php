<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php
nextendimportsmartslider2('nextend.smartslider.settings');

class plgNextendSliderGeneratorInstagram extends NextendPluginBase {

    public static $_group = 'instagram';

    function onNextendSliderGeneratorList(&$group, &$list, $showall = false) {
        $group[self::$_group] = 'Instagram';

        if (!isset($list[self::$_group])) $list[self::$_group] = array();
	
	      $configured = is_string(NextendSmartSliderStorage::get(self::$_group));
	
        $list[self::$_group][self::$_group . '_myfeed'] = array(NextendText::_('My_feed'), $this->getPath() . 'myfeed' . DIRECTORY_SEPARATOR, $configured, true, true, 'image_extended');
        $list[self::$_group][self::$_group . '_tagsearch'] = array(NextendText::_('Search_by_tag'), $this->getPath() . 'tagsearch' . DIRECTORY_SEPARATOR, $configured, true, true, 'image_extended');
        $list[self::$_group][self::$_group . '_myphotos'] = array(NextendText::_('My photos'), $this->getPath() . 'myphotos' . DIRECTORY_SEPARATOR, $configured, true, true, 'image_extended');
    }

    function onNextendInstagram(&$instagram) {
        $config = new NextendData();
        $config->loadJson(NextendSmartSliderStorage::get(self::$_group));

        require_once(dirname(__FILE__) . "/api/Instagram.php");
        $c = array(
            'client_id' => $config->get('apikey', ''),
            'client_secret' => $config->get('apisecret', ''),
            'redirect_uri' => '',
            'grant_type' => 'authorization_code',
        );

        $instagram = new Instagram($c);

        $instagram->setAccessToken($config->get('token', ''));
    }
    
    function onNextendGeneratorConfigurationList(&$list){
        $list[] = array('id' => self::$_group, 'title' => NextendText::_('Instagram generator'));
    }
    
    function onNextendGeneratorConfiguration(&$group, &$path){
        if($group == self::$_group){
            $path = $this->getPath();
        }
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR;
    }
}

/**
 * @return Instagram
 */
function getNextendInstagram() {
    $instagram = null;
    NextendPlugin::callPlugin('nextendslidergenerator', 'onNextendInstagram', array(&$instagram));

    $test = json_decode($instagram->getUserFeed(), true);

    if ($test['meta']['code'] != 200) {
        if (NextendSmartSliderSettings::get('debugmessages', 1)) {
            global $smartslidercontroller;
            echo "<span style='line-height: 24px; padding: 0 10px;'>";
            echo NextendText::_('There_are_some_configuration_issues_with_Instagram_API_Please_check_the').' <a href="' . $smartslidercontroller->route('controller=settings&view=sliders_settings&action=instagram') . '">'.NextendText::_('settings').'</a>!<br />';
            echo "</span>";
        }
        return false;
    }
    return $instagram;
}

NextendPlugin::addPlugin('nextendslidergenerator', 'plgNextendSliderGeneratorInstagram');