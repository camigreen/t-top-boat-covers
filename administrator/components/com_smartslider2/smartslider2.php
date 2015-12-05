<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

JToolBarHelper::title('Smart Slider 2');

jimport('nextend.library');

defined('NEXTEND_SMART_SLIDER2_ASSETS') || define('NEXTEND_SMART_SLIDER2_ASSETS', NEXTENDLIBRARY . 'assets' . DIRECTORY_SEPARATOR . 'smartslider' . DIRECTORY_SEPARATOR );

jimport('nextend.smartslider.admin.controller');

$controller = new NextendSmartsliderAdminController('com_smartslider2');
$controller->initBase();
$controller->run();
