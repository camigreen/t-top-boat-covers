<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php
nextendimport('nextend.form.element.subform');

class NextendElementSlidertype extends NextendElementSubform {
    var $_list = null;
    function getOptions(){
        if($this->_list == null){
            $this->loadList();
        }
        $list = array_keys($this->_list);
        sort($list);
        return $list;
    }
    
    function getSubFormfolder($value){
        if($this->_list == null){
            $this->loadList();
        }
        if(!isset($this->_list[$value])) list($value) = array_keys($this->_list);
        return $this->_list[$value];
    }
    
    function loadList(){
        $this->_list = array();
        NextendPlugin::callPlugin('nextendslidertype', 'onNextendSliderTypeList', array(&$this->_list));
    }
}