<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.check');

class plgNextendSliderGeneratorIgnitegallery extends NextendPluginBase {

    var $_group = 'ignitegallery';

    function onNextendSliderGeneratorList(&$group, &$list, $showall = false) {
        if ($showall || smartsliderIsFull()) {
            $installed = NextendFilesystem::existsFolder(JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_igallery');
            if ($showall || $installed) {
                $group[$this->_group] = 'Ignite Gallery';

                if (!isset($list[$this->_group]))
                    $list[$this->_group] = array();
                $list[$this->_group][$this->_group . '_ignitegalleryimages'] = array(NextendText::_('Images'), $this->getPath() . 'ignitegalleryimages' . DIRECTORY_SEPARATOR, true, true, $installed ? true : 'http://extensions.joomla.org/extensions/photos-a-images/galleries/photo-gallery/5396', 'image_extended');
            }
        }
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR;
    }

}

NextendPlugin::addPlugin('nextendslidergenerator', 'plgNextendSliderGeneratorIgnitegallery');
