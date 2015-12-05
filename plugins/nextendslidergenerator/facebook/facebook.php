<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php
nextendimportsmartslider2('nextend.smartslider.settings');

class plgNextendSliderGeneratorFacebook extends NextendPluginBase {

    public static $_group = 'facebook';

    function onNextendSliderGeneratorList(&$group, &$list, $showall = false) {
        $group[self::$_group] = 'Facebook';

        if (!isset($list[self::$_group])) $list[self::$_group] = array();
	
	      $configured = is_string(NextendSmartSliderStorage::get(self::$_group));
	
        $list[self::$_group][self::$_group . '_postsbypage'] = array(NextendText::_('Posts_by_page'), $this->getPath() . 'postsbypage' . DIRECTORY_SEPARATOR, $configured, true, true, 'social_post');
        $list[self::$_group][self::$_group . '_albumbypage'] = array(NextendText::_('Photos_by_page_album'), $this->getPath() . 'albumbypage' . DIRECTORY_SEPARATOR, $configured, true, true, 'image_extended');
        $list[self::$_group][self::$_group . '_albumbyuser'] = array(NextendText::_('Photos_by_user_album'), $this->getPath() . 'albumbyuser' . DIRECTORY_SEPARATOR, $configured, true, true, 'image_extended');
    }

    function onNextendFacebook(&$facebook) {
        $config = new NextendData();
        $config->loadJson(NextendSmartSliderStorage::get(self::$_group));

        require_once(dirname(__FILE__) . "/api/facebook.php");

        $facebook = new Facebook(array(
            'appId' => $config->get('apikey', ''),
            'secret' => $config->get('apisecret', ''),
        ));

        $facebook->setAccessToken($config->get('token', ''));
    }

    function onNextendFacebookPageAlbums(&$data){
        $page = NextendRequest::getVar('fbpage', '');
        $api = getNextendFacebook();
        $data = array();
        if ($api) {
            try {
                $result = $api->api($page.'/albums');
                if (count($result['data'])) {
                    foreach ($result['data'] AS $album) {
                        $data[$album['id']] = $album['name'];
                    }
                }
            } catch (Exception $e) {
                $data = null;
            }
        }
    }
    
    function onNextendGeneratorConfigurationList(&$list){
        $list[] = array('id' => self::$_group, 'title' => NextendText::_('Facebook generator'));
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
 * @return Facebook
 */
function getNextendFacebook() {

    $facebook = null;
    NextendPlugin::callPlugin('nextendslidergenerator', 'onNextendFacebook', array(&$facebook));

    try {
        $test = $facebook->api('/me');
    } catch (Exception $e) {
        if (NextendSmartSliderSettings::get('debugmessages', 1)) {
            global $smartslidercontroller;
            echo "<span style='line-height: 24px; padding: 0 10px;'>";
            echo NextendText::_('There_are_some_configuration_issues_with_Facebook_API_Please_check_the').' <a href="' . $smartslidercontroller->route('controller=settings&view=sliders_settings&action=facebook') . '">'.NextendText::_('settings').'</a>!<br />';
            echo "</span>";
        }
        return false;
    }

    return $facebook;
}

NextendPlugin::addPlugin('nextendslidergenerator', 'plgNextendSliderGeneratorFacebook');