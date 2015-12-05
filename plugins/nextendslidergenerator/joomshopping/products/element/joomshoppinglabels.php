<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.form.element.list');

class NextendElementJoomShoppingLabels extends NextendElementList {

    function fetchElement() {

        $db = JFactory::getDBO();
        
        require_once(JPATH_SITE . "/components/com_jshopping/lib/factory.php");
        $lang = JSFactory::getLang();
        
        $query = "SELECT id, `".$lang->get('name')."` AS name
              FROM #__jshopping_product_labels
              ORDER BY name";

        $db->setQuery($query);
        $menuItems = $db->loadObjectList();

        $this->_xml->addChild('option', 'None')->addAttribute('value', 0);
        if (count($menuItems)) {
            foreach ($menuItems AS $option) {
                $this->_xml->addChild('option', $option->name)->addAttribute('value', $option->id);
            }
        }
        $this->_value = $this->_form->get($this->_name, $this->_default);
        $html = parent::fetchElement();
        return $html;
    }

}
