<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

class plgNextendSliderWidgetBar extends NextendPluginBase {

    var $_group = 'bar';

    function onNextendSliderWidgetList(&$list) {
        $list[$this->_group] = array(NextendText::_('Bar'), $this->getPath(), 5);
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'bar' . DIRECTORY_SEPARATOR;
    }
}
NextendPlugin::addPlugin('nextendsliderwidget', 'plgNextendSliderWidgetBar');