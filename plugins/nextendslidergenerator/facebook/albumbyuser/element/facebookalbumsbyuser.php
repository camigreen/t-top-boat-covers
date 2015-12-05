<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.form.element.list');

class NextendElementFacebookAlbumsByUser extends NextendElementList {

    function fetchElement() {

        $this->_xml->addChild('option', 'Please choose')->addAttribute('value', 0);

        ob_start();
        $api = getNextendFacebook();
        $list = array();
        if ($api) {
            try {
                $result = $api->api('/me/albums');
                if (count($result['data'])) {
                    foreach ($result['data'] AS $album) {
                        $list[$album['id']] = $album['name'];
                    }
                }
            } catch (Exception $e) {
                $list = null;
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
