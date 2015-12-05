<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.smartslider.generator_abstract');

class NextendGeneratorIgnitegallery_Ignitegalleryimages extends NextendGeneratorAbstract {

    function NextendGeneratorIgnitegallery_Ignitegalleryimages($data) {
        parent::__construct($data);
        $this->_variables = array(
            'title' => NextendText::_('Alt_text_of_the_image'),
            'image' => NextendText::_('Image'),
            'thumbnail' => NextendText::_('Thumbnail'),
            'description' => NextendText::_('Description_of_the_image'),
            'url' => NextendText::_('Url_of_the_image'),
            
            'filename' => NextendText::_('Filename_of_the_image'),
            'link' => NextendText::_('Link_of_the_image'),
            'gallery_id' => NextendText::_('Id_of_the_image_s_category'),
            'cat_title' => NextendText::_('Title_of_the_image_s_category'),
            'cat_alias' => NextendText::_('Alias_of_the_image_s_category'),
            'categoryurl' => NextendText::_('Url_to_the_image_s_category'),
            'hits' => NextendText::_('Hits_of_the_image')
        );
    }

    function getData($number) {

        require_once(JPATH_ADMINISTRATOR.'/components/com_igallery/defines.php');
        
        nextendimport('nextend.database.database');
        $db = NextendDatabase::getInstance();

        $data = array();

        $category = array_map('intval', explode('||', $this->_data->get('ignitegallerysourcecategory', '')));

        $query = 'SELECT ';
        $query .= 'con.id, ';
        $query .= 'con.filename, ';
        $query .= 'con.description, ';
        $query .= 'con.alt_text, ';
        $query .= 'con.link, ';
        $query .= 'con.hits, ';
        $query .= 'con.rotation, ';
        
        $query .= 'con.gallery_id, ';
        $query .= 'cat.name AS cat_title, ';
        $query .= 'cat.alias AS cat_alias ';

        $query .= 'FROM #__igallery_img AS con ';

        $query .= 'LEFT JOIN #__igallery AS cat ON cat.id = con.gallery_id ';
        
        $where = array();
        if(count($category) > 0 && !in_array('0', $category)){        
            $where[]= 'con.gallery_id IN (' . implode(',', $category) . ') ';
        }
        
        if ($this->_data->get('ignitegallerysourcepublished', 1)) {
            $where[]= 'con.published = 1 ';
        }
        
        if(count($where)){
            $query .= ' WHERE '. implode(' AND ', $where);
        }

        $order = NextendParse::parse($this->_data->get('ignitegalleryorder1', 'con.ordering|*|asc'));
        if ($order[0]) {
            $query .= 'ORDER BY ' . $order[0] . ' ' . $order[1] . ' ';
            $order = NextendParse::parse($this->_data->get('ignitegalleryorder2', 'con.ordering|*|asc'));
            if ($order[0]) {
                $query .= ', ' . $order[0] . ' ' . $order[1] . ' ';
            }
        }

        $query .= 'LIMIT 0, ' . $number . ' ';
        
        $db->setQuery($query);
        $result = $db->loadAssocList();

        for ($i = 0; $i < count($result); $i++) {
            $fileHashNoExt = JFile::stripExt($result[$i]['filename']);
            $fileHashNoRef = substr($fileHashNoExt, 0, strrpos($fileHashNoExt, '-') );
            $result[$i]['url'] = 'index.php?option=com_igallery&view=category&igid=' . $result[$i]['gallery_id'] . '#!'.$fileHashNoRef;
            $result[$i]['categoryurl'] = 'index.php?option=com_igallery&view=category&igid=' . $result[$i]['gallery_id'];

            $increment = igFileHelper::getIncrementFromFilename($result[$i]['filename']);
	          $folderName = igFileHelper::getFolderName($increment);
            $sourceFile = IG_ORIG_PATH.'/'.$folderName.'/'.$result[$i]['filename'];
            $size = getimagesize($sourceFile);
            
            $fileArray = igFileHelper::originalToResized($result[$i]['filename'], $size[0], $size[1], 100, 0, $result[$i]['rotation'], 0, 0);
            
            $result[$i]['thumbnail'] =$result[$i]['image'] = IG_IMAGE_HTML_RESIZE.$fileArray['folderName'].'/'.$fileArray['fullFileName'];
            
            $result[$i]['title'] = $result[$i]['alt_text'];
            $result[$i]['author_name'] = '';
            $result[$i]['author_url'] = '#';
            
        }
        
        return $result;
    }
}