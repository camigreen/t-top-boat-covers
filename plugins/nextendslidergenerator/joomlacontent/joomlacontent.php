<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.check');

class plgNextendSliderGeneratorJoomlaContent extends NextendPluginBase {

    var $_group = 'joomlacontent';

    function onNextendSliderGeneratorList(&$group, &$list, $showall = false) {
        if ($showall || smartsliderIsFull()) {
            $group[$this->_group] = 'Joomla content';
    
            if (!isset($list[$this->_group])) $list[$this->_group] = array();
            $list[$this->_group][$this->_group . '_joomlacontent'] = array(NextendText::_('Contents_by_category'), $this->getPath() . 'joomlacontent' . DIRECTORY_SEPARATOR, true, true, true, 'article');
            $list[$this->_group][$this->_group . '_joomlacategory'] = array(NextendText::_('Subcategories_by_category'), $this->getPath() . 'joomlacategory' . DIRECTORY_SEPARATOR, true, true, true, 'article');
	    $list[$this->_group][$this->_group . '_joomlalimitedcategory'] = array('Limit to group result', $this->getPath() . 'joomlalimitedcategory' . DIRECTORY_SEPARATOR, true, true, true, 'article');
        }
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR;
    }
}

NextendPlugin::addPlugin('nextendslidergenerator', 'plgNextendSliderGeneratorJoomlaContent');