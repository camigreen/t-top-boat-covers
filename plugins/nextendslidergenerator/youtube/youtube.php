<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php
nextendimportsmartslider2('nextend.smartslider.settings');

class plgNextendSliderGeneratorYoutube extends NextendPluginBase {

    public static $_group = 'youtube';

    function onNextendSliderGeneratorList(&$group, &$list, $showall = false) {
        $group[self::$_group] = 'YouTube';

        if (!isset($list[self::$_group])) $list[self::$_group] = array();
	
	      $configured = is_string(NextendSmartSliderStorage::get(self::$_group));
	
        $list[self::$_group][self::$_group . '_bysearch'] = array('By search', $this->getPath() . 'bysearch' . DIRECTORY_SEPARATOR, $configured, true, true, 'youtube');
        $list[self::$_group][self::$_group . '_byplaylist'] = array('By playlist', $this->getPath() . 'byplaylist' . DIRECTORY_SEPARATOR, $configured, true, true, 'youtube');
    }

    function onNextendYoutube(&$google, &$youtube) {
        $config = new NextendData();
        $config->loadJson(NextendSmartSliderStorage::get(self::$_group));
        
        if (!class_exists('Google_Client')) require_once dirname(__FILE__) . '/googleclient/Google_Client.php';
        if (!class_exists('Google_YouTubeService')) require_once dirname(__FILE__) . '/googleclient/contrib/Google_YouTubeService.php';

        $google = new Google_Client();
        $google->setClientId($config->get('apikey', ''));
        $google->setClientSecret($config->get('apisecret', ''));
        
        $token = $config->get('token', null);
        if($token) $google->setAccessToken($token);
        
        $youtube = new Google_YouTubeService($google);
        if ($google->isAccessTokenExpired()) {
            $token = json_decode($google->getAccessToken(), true);
            if(isset($token['refresh_token'])){
                $google->refreshToken($token['refresh_token']);
                $config->set('token', $google->getAccessToken());
                NextendSmartSliderStorage::set(self::$_group, $config->toJSON());
            }
        }
    }
    
    function onNextendGeneratorConfigurationList(&$list){
        $list[] = array('id' => self::$_group, 'title' => NextendText::_('YouTube generator'));
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
 * @return array(Google_Client,Google_Client_YouTube)
 */
function getNextendYoutube() {
    static $google = null, $youtube = null;
    if($google === null){
        NextendPlugin::callPlugin('nextendslidergenerator', 'onNextendYoutube', array(&$google, &$youtube));
    }
    
    if ($google->isAccessTokenExpired()) {
        if (NextendSmartSliderSettings::get('debugmessages', 1)) {
            global $smartslidercontroller;
            echo "<span style='line-height: 24px; padding: 0 10px;'>";
            echo NextendText::_('There are some configuration issues with Youtube API. Please check the').' <a href="' . $smartslidercontroller->route('controller=settings&view=sliders_settings&action=youtube') . '">'.NextendText::_('settings').'</a>!<br />';
            echo "</span>";
        }
        return false;
    }
    return array($google, $youtube);
}

NextendPlugin::addPlugin('nextendslidergenerator', 'plgNextendSliderGeneratorYoutube');