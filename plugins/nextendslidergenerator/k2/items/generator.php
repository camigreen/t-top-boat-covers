<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.smartslider.generator_abstract');

class NextendGeneratorK2_Items extends NextendGeneratorAbstract {

    var $extraFields;

    function NextendGeneratorK2_Items($data) {
        parent::__construct($data);
        $this->extraFields = array();
        $this->_variables = array(
            'title' => NextendText::_('Title_of_the_item'),
            'image' => NextendText::_('Image_for_the_item'),
            'thumbnail' => NextendText::_('Image_for_the_item'),
            'description' => NextendText::_('Intro_of_the_item'),
            'url' => NextendText::_('Url_of_the_item'),
            'alias' => NextendText::_('Alias_of_the_item'),
            'fulltext' => NextendText::_('Text_of_the_item'),
            'catid' => NextendText::_('Id_of_the_item_s_category'),
            'cat_title' => NextendText::_('Title_of_the_item_s_category'),
            'categoryurl' => NextendText::_('Url_to_the_item_s_category'),
            'created_by' => NextendText::_('Id_of_the_item_s_creator'),
            'author_name' => NextendText::_('Name_of_the_article_s_creator'),
            'image_caption' => NextendText::_('Image_caption_for_the_item'),
            'image_credits' => NextendText::_('Image_credits_for_the_item'),
            'hits' => NextendText::_('Hits_of_the_item')
        );

        $this->loadExtraFields();
        if (count($this->extraFields) > 0) {
            foreach ($this->extraFields AS $v) {
                $this->_variables['extra' . $v['id'] . '_' . preg_replace("/\W|_/", "", $v['group_name'] . '_' . $v['name'])] = 'Extra field ' . $v['name'] . ' of the item';
            }
        }
    }

    function loadExtraFields() {
        static $extraFields = null;
        if ($extraFields === null) {
            $db = NextendDatabase::getInstance();

            $query = 'SELECT ';
            $query .= 'groups.name AS group_name, ';
            $query .= 'field.name AS name, ';
            $query .= 'field.id ';

            $query .= 'FROM #__k2_extra_fields_groups AS groups ';

            $query .= 'LEFT JOIN #__k2_extra_fields AS field ON field.group = groups.id ';

            $query .= 'WHERE field.published = 1 ';

            $db->setQuery($query);
            $this->extraFields = $db->loadAssocList('id');
        }
    }

    function getData($number) {

        nextendimport('nextend.database.database');
        $db = NextendDatabase::getInstance();

        $data = array();

        $category = array_map('intval', explode('||', $this->_data->get('k2itemssourcecategory', '')));

        $query = 'SELECT ';
        $query .= 'con.id, ';
        $query .= 'con.title, ';
        $query .= 'con.alias, ';
        $query .= 'con.introtext, ';
        $query .= 'con.fulltext, ';
        $query .= 'con.catid, ';
        $query .= 'cat.name AS cat_title, ';
	$query .= 'cat.description AS cat_description, ';
        $query .= 'cat.alias AS cat_alias, ';
        $query .= 'con.created_by, ';
        $query .= 'usr.name AS created_by_alias, ';
        $query .= 'con.hits, ';
        $query .= 'con.image_caption, ';
        $query .= 'con.image_credits, ';
        $query .= 'con.extra_fields ';

        $query .= 'FROM #__k2_items AS con ';

        $query .= 'LEFT JOIN #__users AS usr ON usr.id = con.created_by ';

        $query .= 'LEFT JOIN #__k2_categories AS cat ON cat.id = con.catid ';


        $query .= 'WHERE con.catid IN (' . implode(',', $category) . ') ';
        $sourceuserid = intval($this->_data->get('k2itemssourceuserid', ''));
        if ($sourceuserid) {
            $query .= 'AND con.created_by = ' . $sourceuserid . ' ';
        }
        if ($this->_data->get('k2itemssourcepublished', 1)) {
            $jnow = JFactory::getDate();
            $now = version_compare(JVERSION,'1.6.0','<') ? $jnow->toMySQL() : $jnow->toSql();
            $query .= "AND con.published = 1 AND (con.publish_up = '0000-00-00 00:00:00' OR con.publish_up < '".$now."') AND (con.publish_down = '0000-00-00 00:00:00' OR con.publish_down > '".$now."') ";
        }
        $query .= 'AND con.trash = 0 ';

        if ($this->_data->get('k2itemssourcefeatured', 0)) {
            $query .= 'AND con.featured = 1 ';
        }
        $language = $this->_data->get('k2itemssourcelanguage', '*');
        if ($language) {
            $query .= 'AND con.language = ' . $db->quote($language) . ' ';
        }

        $order = NextendParse::parse($this->_data->get('k2itemsorder1', 'con.title|*|asc'));
        if ($order[0]) {
            $query .= 'ORDER BY ' . $order[0] . ' ' . $order[1] . ' ';
            $order = NextendParse::parse($this->_data->get('k2itemsorder2', 'con.title|*|asc'));
            if ($order[0]) {
                $query .= ', ' . $order[0] . ' ' . $order[1] . ' ';
            }
        }


        $query .= 'LIMIT 0, ' . $number . ' ';

        $db->setQuery($query);
        $result = $db->loadAssocList();

        $this->loadExtraFields();
        
        require_once(JPATH_SITE.'/components/com_k2/helpers/utilities.php');
        require_once(JPATH_SITE.'/components/com_k2/models/item.php');
        $k2item = new K2ModelItem();

        for ($i = 0; $i < count($result); $i++) {
            $result[$i]['url'] = 'index.php?option=com_k2&view=item&id=' . $result[$i]['id'] . ':' . $result[$i]['alias'];
            $result[$i]['categoryurl'] = 'index.php?option=com_k2&view=itemlist&task=category&id=' . $result[$i]['catid'] . ':' . $result[$i]['cat_alias'];

            $result[$i]['thumbnail'] = $result[$i]['image'] = "media/k2/items/cache/" . md5("Image" . $result[$i]['id']) . "_XL.jpg";
            
            if(!NextendFilesystem::fileexists(JPATH_SITE.'/'.$result[$i]['image'])){
                $result[$i]['thumbnail'] = $result[$i]['image'] = '';
            }
            
            $result[$i]['description'] = $result[$i]['introtext'];
            
            $result[$i]['url_label'] = 'View article'; 
            $result[$i]['author_name'] = $result[$i]['created_by_alias']; 
            $result[$i]['author_url'] = '#';
            
            $item = (object)$result[$i];
            $extras = $k2item->getItemExtraFields($result[$i]['extra_fields'],$item);
            
            if (is_array($extras) && count($extras) > 0) {
                foreach ($extras AS $field) {
                    $result[$i]['extra' . $field->id . '_' . preg_replace("/\W|_/", "", $this->extraFields[$field->id]['group_name'] . '_' . $this->extraFields[$field->id]['name'])] = $field->value;
                }
            }
        }
        return $result;
    }
}