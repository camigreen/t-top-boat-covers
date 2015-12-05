<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

class NextendElementGeneratorvariables extends NextendElement {

    function fetchElement() {
        global $generatorinstance;
        $generatorinstance->initAdmin();
        return '<div id='.$this->_id.'>'.$generatorinstance->generateList().'</div>';
    }

}