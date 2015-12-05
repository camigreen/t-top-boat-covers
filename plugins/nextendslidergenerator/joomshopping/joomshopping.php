<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.check');

class plgNextendSliderGeneratorJoomShopping extends NextendPluginBase {

    var $_group = 'joomshopping';

    function onNextendSliderGeneratorList(&$group, &$list, $showall = false) {
        if ($showall || smartsliderIsFull()) {
            $installed = NextendFilesystem::existsFile(JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_jshopping' . DIRECTORY_SEPARATOR . 'jshopping.php');
            if ($showall || $installed) {
                $group[$this->_group] = 'JoomShopping';
                if (!isset($list[$this->_group]))
                    $list[$this->_group] = array();
                $list[$this->_group][$this->_group . '_products'] = array(NextendText::_('Products'), $this->getPath() . 'products' . DIRECTORY_SEPARATOR, true, true, $installed ? true : 'http://extensions.joomla.org/extensions/e-commerce/shopping-cart/5378', 'product');
            }
        }
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR;
    }

}

NextendPlugin::addPlugin('nextendslidergenerator', 'plgNextendSliderGeneratorJoomShopping');
