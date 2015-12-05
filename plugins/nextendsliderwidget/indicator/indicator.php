<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

class plgNextendSliderWidgetIndicator extends NextendPluginBase {

    var $_group = 'indicator';

    function onNextendSliderWidgetList(&$list) {
        $list[$this->_group] = array(NextendText::_('Indicator'), $this->getPath(), 4);
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'indicator' . DIRECTORY_SEPARATOR;
    }
}
NextendPlugin::addPlugin('nextendsliderwidget', 'plgNextendSliderWidgetIndicator');