<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.smartslider.generator_abstract');

class NextendGeneratorphocagallery_phocagalleryimages extends NextendGeneratorAbstract {

    function NextendGeneratorphocagallery_phocagalleryimages($data) {
        parent::__construct($data);
        $this->_variables = array(
            'title' => NextendText::_('Title_of_the_image'),
            'image' => NextendText::_('Image'),
            'thumbnail' => NextendText::_('Thumbnail'),
            'description' => NextendText::_('Description'),
            'url' => NextendText::_('Url_of_the_image'),
            
            'id' => NextendText::_('ID_of_the_image'),
            'alias' => NextendText::_('Alias_of_the_image'),
            'catid' => NextendText::_('Id_of_the_image_s_category'),
            'cat_title' => NextendText::_('Title_of_the_image_s_category'),
            'categoryurl' => NextendText::_('Url_to_the_image_s_category'),
            'hits' => NextendText::_('Hits_of_the_image')
        );
    }

    function getData($number) {

        nextendimport('nextend.database.database');
        $db = NextendDatabase::getInstance();

        $data = array();

        $category = array_map('intval', explode('||', $this->_data->get('phocagallerysourcecategory', '')));

        $query = 'SELECT ';
        $query .= 'con.id, ';
        $query .= 'con.title, ';
        $query .= 'con.alias, ';
        $query .= 'con.filename, ';
        $query .= 'con.description, ';
        $query .= 'con.hits, ';
        
        $query .= 'con.catid, ';
        $query .= 'cat.title AS cat_title, ';
        $query .= 'cat.description AS cat_description, ';
        $query .= 'cat.alias AS cat_alias ';

        $query .= 'FROM #__phocagallery AS con ';

        $query .= 'LEFT JOIN #__phocagallery_categories AS cat ON cat.id = con.catid ';
        
        $where = array();
        if(count($category) > 0 && !in_array('0', $category)){        
            $where[]= 'con.catid IN (' . implode(',', $category) . ') ';
        }
        
        if ($this->_data->get('phocagallerysourcepublished', 1)) {
            $where[]= 'con.published = 1 ';
            $where[]= 'con.approved = 1 ';
        }

        if ($this->_data->get('phocagallerysourcefeatured', 0)) {
            $where[]= 'con.featured = 1 ';
        }
        $language = $this->_data->get('phocagallerysourcelanguage', '*');
        if ($language) {
            $where[]= 'con.language = ' . $db->quote($language) . ' ';
        }
        
        if(count($where)){
            $query .= ' WHERE '. implode(' AND ', $where);
        }

        $order = NextendParse::parse($this->_data->get('phocagalleryorder1', 'con.title|*|asc'));
        if ($order[0]) {
            $query .= 'ORDER BY ' . $order[0] . ' ' . $order[1] . ' ';
            $order = NextendParse::parse($this->_data->get('phocagalleryorder2', 'con.title|*|asc'));
            if ($order[0]) {
                $query .= ', ' . $order[0] . ' ' . $order[1] . ' ';
            }
        }

        $query .= 'LIMIT 0, ' . $number . ' ';
        
        $db->setQuery($query);
        $result = $db->loadAssocList();

        $uri = str_replace(array('http://', 'https://'), '//', NextendUri::getBaseUri());
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]['url'] = 'index.php?option=com_phocagallery&view=detail&catid=' . $result[$i]['catid'] . ':' . $result[$i]['cat_alias'].'&id=' . $result[$i]['id'] . ':' . $result[$i]['alias'];
            $result[$i]['url_label'] = 'View image';
            
            $result[$i]['categoryurl'] = 'index.php?option=com_phocagallery&view=category&id=' . $result[$i]['catid'] . ':' . $result[$i]['cat_alias'];

            $result[$i]['thumbnail'] = $result[$i]['image'] = $uri."images/phocagallery/" . $result[$i]['filename'];
            if(!$result[$i]['description']) $result[$i]['description'] = '';
            
            $result[$i]['author_name'] = '';
            $result[$i]['author_url'] = '#';
        }
        
        return $result;
    }
}