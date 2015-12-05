<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.form.element.list');

class NextendElementCobaltCategories extends NextendElementList {

    function fetchElement() {

        $db = JFactory::getDBO();

        $query = "SELECT
            id,
            name
            FROM #__js_res_sections
            ORDER BY ordering ASC
            ";

        $db->setQuery($query);
        $sections = $db->loadAssocList('id');

        $query = "SELECT DISTINCT 
            id, 
            title,
            title AS name,
            parent_id,
            parent_id AS parent,
            section_id
            FROM #__js_res_categories
            ORDER BY lft ASC
        ";

        $db->setQuery($query);
        $categories = $db->loadObjectList();

        $children = array();
        if ($categories) {
            foreach ($categories as $v) {
                $pt = $v->parent_id;
                $list = isset($children[$pt]) ? $children[$pt] : array();
                array_push($list, $v);
                $children[$pt] = $list;
            }
        }
        jimport('joomla.html.html.menu');
        $options = JHTML::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 0);
        $this->_xml->addChild('option', 'Any category')->addAttribute('value', '0');

        $sectionOptgroup = array();

        if (count($options)) {
            foreach ($options AS $option) {
                if (isset($sections[$option->section_id])) {
                    if (!isset($sectionOptgroup[$option->section_id])) {
                        $sectionOptgroup[$option->section_id] = $this->_xml->addChild('optgroup', '');
                        $sectionOptgroup[$option->section_id]->addAttribute('label', htmlspecialchars($sections[$option->section_id]['name']) . ' - section');
                    }
                    $sectionOptgroup[$option->section_id]->addChild('option', htmlspecialchars($option->treename))->addAttribute('value', $option->id);
                } else {
                    $this->_xml->addChild('option', htmlspecialchars($option->treename))->addAttribute('value', $option->id);
                }
            }
        }

        $html = parent::fetchElement();
        return $html;
    }
}
