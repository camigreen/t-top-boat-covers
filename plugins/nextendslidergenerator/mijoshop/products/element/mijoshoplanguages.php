<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.form.element.list');

class NextendElementMijoshopLanguages extends NextendElementList {

    function fetchElement() {

        $db = JFactory::getDBO();
        
        $query = 'SELECT language_id, name
                FROM #__mijoshop_language
                WHERE status = 1';
        
        $db->setQuery($query);
        $lngs = $db->loadObjectList();
        $this->_xml->addChild('option', 'Automatic')->addAttribute('value', '');

        if (count($lngs)) {
            foreach ($lngs AS $lng) {
                $this->_xml->addChild('option', $lng->name)->addAttribute('value', $lng->language_id);
            }
        }
        $this->_value = $this->_form->get($this->_name, '');
        $html = parent::fetchElement();
        return $html;
    }

}
