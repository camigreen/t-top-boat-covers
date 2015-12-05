<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

class plgNextendSliderWidgetAutoplay extends NextendPluginBase {

    var $_group = 'autoplay';

    function onNextendSliderWidgetList(&$list) {
        $list[$this->_group] = array(NextendText::_('Autoplay'), $this->getPath(), 3);
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'autoplay' . DIRECTORY_SEPARATOR;
    }
}
NextendPlugin::addPlugin('nextendsliderwidget', 'plgNextendSliderWidgetAutoplay');