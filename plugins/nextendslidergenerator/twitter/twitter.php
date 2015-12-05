<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php
nextendimportsmartslider2('nextend.smartslider.settings');

class plgNextendSliderGeneratorTwitter extends NextendPluginBase {

    public static $_group = 'twitter';

    function onNextendSliderGeneratorList(&$group, &$list, $showall = false) {
        $group[self::$_group] = 'Twitter';

        if (!isset($list[self::$_group])) $list[self::$_group] = array();
	
	      $configured = is_string(NextendSmartSliderStorage::get(self::$_group));
	
        $list[self::$_group][self::$_group . '_timeline'] = array(NextendText::_('Timeline'), $this->getPath() . 'twittertimeline' . DIRECTORY_SEPARATOR, $configured, true, true, 'social_post');
    }

    function onNextendTwitter(&$twitter) {
        $config = new NextendData();
        $config->loadJson(NextendSmartSliderStorage::get(self::$_group));

        require_once(dirname(__FILE__) . "/api/tmhOAuth.php");
        $twitter = new tmhOAuth(array(
          'consumer_key'    => $config->get('apikey', ''),
          'consumer_secret' => $config->get('apisecret', ''),
          'user_token'    => $config->get('token', ''),
          'user_secret' => $config->get('tokensecret', '')
        ));
    }
    
    function onNextendGeneratorConfigurationList(&$list){
        $list[] = array('id' => self::$_group, 'title' => NextendText::_('Twitter generator'));
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


function getNextendTwitter() {

    $twitter = null;
    NextendPlugin::callPlugin('nextendslidergenerator', 'onNextendTwitter', array(&$twitter));
    
    $test = $twitter->request('GET', 'https://api.twitter.com/1.1/statuses/user_timeline.json' , array(
    ));    

    if ($test != 200) {
        if (NextendSmartSliderSettings::get('debugmessages', 1)) {
            global $smartslidercontroller;
            echo "<span style='line-height: 24px; padding: 0 10px;'>";
            echo NextendText::_('There_are_some_configuration_issues_with_Twitter_API_Please_check_the').' <a href="' . $smartslidercontroller->route('controller=settings&view=sliders_settings&action=twitter') . '">'.NextendText::_('settings').'</a>!<br />';
            echo "</span>";
        }
        return false;
    }
    return $twitter;
}

NextendPlugin::addPlugin('nextendslidergenerator', 'plgNextendSliderGeneratorTwitter');