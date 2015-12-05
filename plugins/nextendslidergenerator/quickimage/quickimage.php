<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.check');

class plgNextendSliderGeneratorQuickImage extends NextendPluginBase {

    var $_group = 'imagefromfolder';

    function onNextendSliderGeneratorList(&$group, &$list, $showall = false) {
        $group[$this->_group] = 'Image';

        if (!isset($list[$this->_group])) $list[$this->_group] = array();
        $list[$this->_group][$this->_group . '_quickimage'] = array(NextendText::_('Quick_image'), $this->getPath() . 'quickimage' . DIRECTORY_SEPARATOR, true, false, true, 'image_quick');
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR;
    }
}

NextendPlugin::addPlugin('nextendslidergenerator', 'plgNextendSliderGeneratorQuickImage');