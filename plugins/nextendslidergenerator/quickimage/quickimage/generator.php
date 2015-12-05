<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.generator_abstract');

class NextendGeneratorimagefromfolder_quickimage extends NextendGeneratorAbstract {

    function NextendGeneratorimagefromfolder_quickimage($data) {
        parent::__construct($data);
        $this->_variables = array(
            'image' => NextendText::_('Url_to_the_image'),
            'title' => NextendText::_('Title'),
            'description' => NextendText::_('Description'),
            'url' => NextendText::_('Link')
        );
    }

    function getData($number) {

        $data = array();

        $images = json_decode($this->_data->get('images', ''), true);
        
        for($i = 0; $i < count($images); $i++){
            $images[$i]['thumbnail'] = $images[$i]['image'];
            if($images[$i]['url'] == '') $images[$i]['url'] = '#';
            $images[$i]['url_label'] = 'View';
            $images[$i]['author_name'] = '';
            $images[$i]['author_url'] = '#';
        }

        return $images;
    }
}