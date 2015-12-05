<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.check');

class plgNextendSliderGeneratorVirtuemart2 extends NextendPluginBase {

    var $_group = 'virtuemart2';

    function onNextendSliderGeneratorList(&$group, &$list, $showall = false) {
        if ($showall || smartsliderIsFull()) {

            $installed = (class_exists('VmConfig', false) || NextendFilesystem::existsFile(JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_virtuemart' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'config.php'));
            if ($showall || $installed) {
                $group[$this->_group] = 'VirtueMart_2';

                if (!isset($list[$this->_group]))
                    $list[$this->_group] = array();
                $list[$this->_group][$this->_group . '_products'] = array(NextendText::_('Products'), $this->getPath() . 'products' . DIRECTORY_SEPARATOR, true, true, $installed ? true : 'http://extensions.joomla.org/extensions/e-commerce/shopping-cart/129', 'product');
            }
        }
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR;
    }

}

NextendPlugin::addPlugin('nextendslidergenerator', 'plgNextendSliderGeneratorVirtuemart2');
