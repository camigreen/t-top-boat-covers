<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

class plgNextendSliderWidgetThumbnail extends NextendPluginBase {

    var $_group = 'thumbnail';

    function onNextendSliderWidgetList(&$list) {
        $list[$this->_group] = array(NextendText::_('Thumbnails'), $this->getPath(), 6);
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'thumbnail' . DIRECTORY_SEPARATOR;
    }
}
NextendPlugin::addPlugin('nextendsliderwidget', 'plgNextendSliderWidgetThumbnail');