<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

class plgNextendSliderWidgetBullet extends NextendPluginBase {

    var $_group = 'bullet';

    function onNextendSliderWidgetList(&$list) {
        $list[$this->_group] = array(NextendText::_('Bullets'), $this->getPath(), 2);
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'bullet' . DIRECTORY_SEPARATOR;
    }
}
NextendPlugin::addPlugin('nextendsliderwidget', 'plgNextendSliderWidgetBullet');