<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.mvc.model');
nextendimport('nextend.database.database');

class NextendSmartsliderAdminModelBase extends NextendModel {
    
    static function markChanged($id){
        NextendSmartSliderStorage::set('sliderchanged'.$id, '1');
    }
}