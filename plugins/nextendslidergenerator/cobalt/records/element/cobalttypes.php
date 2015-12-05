<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.form.element.list');

class NextendElementCobaltTypes extends NextendElementList {

    function fetchElement() {

        $query = "SELECT
            id,
            name
            FROM #__js_res_types
            ORDER BY name ASC
            ";

        $db = JFactory::getDBO();

        $db->setQuery($query);
        $types = $db->loadObjectList();

        $this->_xml->addChild('option', 'Any type')->addAttribute('value', '0');

        if (count($types)) {
            foreach ($types AS $option) {
                $this->_xml->addChild('option', htmlspecialchars($option->name))->addAttribute('value', $option->id);
            }
        }

        $html = parent::fetchElement();
        return $html;
    }
}
