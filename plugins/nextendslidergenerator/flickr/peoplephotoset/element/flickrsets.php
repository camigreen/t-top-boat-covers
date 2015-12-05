<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.form.element.list');

class NextendElementFlickrSets extends NextendElementList {

    function fetchElement() {

        $this->_xml->addChild('option', 'Please choose')->addAttribute('value', '0');
        ob_start();
        $api = getNextendFlickr();
        if ($api) {
            ob_end_clean();
            $result = $api->photosets_getList('');

            if (isset($result['photoset'])) {
                if (count($result['photoset'])) {
                    foreach ($result['photoset'] AS $set) {
                        $this->_xml->addChild('option', htmlentities($set['title']))->addAttribute('value', $set['id']);
                    }
                }
                $this->_value = $this->_form->get($this->_name, $this->_default);
            }
        }
        $html = parent::fetchElement();

        if (!$api) {
            $html .= ob_get_clean();
        }

        return $html;
    }

}
