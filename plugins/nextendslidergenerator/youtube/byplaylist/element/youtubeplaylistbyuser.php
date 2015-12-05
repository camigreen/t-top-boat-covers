<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.form.element.list');

class NextendElementYoutubePlaylistByUser extends NextendElementList {

    function fetchElement() {

        $this->_xml->addChild('option', 'Please choose')->addAttribute('value', 0);

        ob_start();
        $api = getNextendYoutube();
        $list = array();
        if ($api) {
            $google = $api[0];
            $youtube = $api[1];
            try{
                $playlists = $youtube->playlists->listPlaylists('id,snippet', array('mine' => true));
                
                foreach ($playlists['items'] AS $k => $item) {
                    $list[$item['id']] = $item['snippet']['title'];
                }
                
            } catch (Google_ServiceException $e) {
                echo sprintf('<p>A service error occurred: <code>%s</code></p>',
                    htmlspecialchars($e->getMessage()));
            }
    
            catch
            (Google_Exception $e) {
                echo sprintf('<p>An client error occurred: <code>%s</code></p>',
                    htmlspecialchars($e->getMessage()));
            }
        }

        if ($list) {
            ob_end_clean();
            if (count($list)) {
                foreach ($list AS $id => $name) {
                    $this->_xml->addChild('option', htmlentities($name))->addAttribute('value', $id);
                }
            }
        }

        $this->_value = $this->_form->get($this->_name, $this->_default);
        $html = parent::fetchElement();

        if (!$list) {
            $html .= ob_get_clean();
        }

        return $html;
    }

}
