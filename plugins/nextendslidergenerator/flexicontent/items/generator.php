<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.smartslider.generator_abstract');

class NextendGeneratorflexicontent_items extends NextendGeneratorAbstract {

    function NextendGeneratorflexicontent_items($data) {
        parent::__construct($data);
        
        nextendimport('nextend.database.database');
        $db = NextendDatabase::getInstance();
        
        $this->_variables = array(
            'link' => NextendText::_('Link_to_the_article')
        );
        
        $db->setQuery('SELECT * FROM #__flexicontent_fields');
        $result = $db->loadAssocList();
        
        foreach($result AS $field){
            $this->_variables[$field['name']] = $field['label'] .' - '. $field['description'];
        }
    }

    function getData($number) {

        nextendimport('nextend.database.database');
        $db = NextendDatabase::getInstance();

        $data = array();

        $query = 'SELECT ';
        $query .= 'con.id ';

        $query .= 'FROM #__content AS con ';

        $query .= 'LEFT JOIN #__flexicontent_cats_item_relations AS fcat ON fcat.itemid = con.id ';
        $query .= 'LEFT JOIN #__categories AS cat ON fcat.catid = cat.id ';


        $where = array();

        $category = array_map('intval', explode('||', $this->_data->get('sourcecategory', '')));
        if(!in_array('0', $category) && !in_array('1', $category)){
            $where[] = 'fcat.catid IN (' . implode(',', $category) . ') ';
        }
        
        
        if ($this->_data->get('sourcepublished', 1)) {
            $where[] = 'con.state = 1 ';
        }
        if ($this->_data->get('sourcefeatured', 0)) {
            $where[] = 'con.featured = 1 ';
        }
        $language = $this->_data->get('sourcelanguage', '*');
        if ($language) {
            $where[] = 'con.language = ' . $db->quote($language) . ' ';
        }


        if(count($where)){
            $query.= ' WHERE '.implode(' AND ', $where);
        }
        
        
        $query .= 'GROUP BY con.id ';

        $order = NextendParse::parse($this->_data->get('order1', 'con.title|*|asc'));
        if ($order[0]) {
            $query .= 'ORDER BY ' . $order[0] . ' ' . $order[1] . ' ';
            $order = NextendParse::parse($this->_data->get('order2', 'con.title|*|asc'));
            if ($order[0]) {
                $query .= ', ' . $order[0] . ' ' . $order[1] . ' ';
            }
        }

        $query .= 'LIMIT 0, ' . $number . ' ';

        $db->setQuery($query);
        $result = $db->loadAssocList();
        
        
        $lng = JFactory::getLanguage();
        $adminapp = JFactory::$application;
        $siteapp = JApplicationCms::getInstance('site');
        $siteapp->loadLanguage($lng);        

        require_once (JPATH_ADMINISTRATOR.DS.'components/com_flexicontent/defineconstants.php');
        JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_flexicontent'.DS.'tables');
        require_once (JPATH_SITE.DS.'components'.DS.'com_flexicontent'.DS.'helpers'.DS.'permission.php');
        require_once(JPATH_SITE.DS."components/com_flexicontent/classes/flexicontent.fields.php");
        require_once(JPATH_SITE.DS."components/com_flexicontent/classes/flexicontent.helper.php");
        require_once(JPATH_SITE.'/components/com_flexicontent/models/item.php');
        
        $app  = JFactory::getApplication();
        $user = JFactory::getUser();
        $aid = FLEXI_J16GE ? $user->getAuthorisedViewLevels() : (int) $user->get('aid');
        
        $itemmodel = FLEXI_J16GE ? new FlexicontentModelItem() : new FlexicontentModelItems();
        
        
        for ($i = 0; $i < count($result); $i++) {
            $data[$i] = array();
            
            JFactory::$application = $siteapp;
            $item = $itemmodel->getItem($result[$i]['id'], $check_view_access=false);
            list($item) = FlexicontentFields::getFields($item, '', $item->parameters, $aid);
            JFactory::$application = $adminapp;
            $data[$i]['link'] = FlexicontentHelperRoute::getItemRoute($item->id, $item->catid );
            
            foreach($item->fields AS $k => $field){
                $data[$i][$k] = FlexicontentFields::getFieldDisplay($item, $k, $values=null, $method='display');
            }
        }
        JFactory::$application = $adminapp;
        return $data;
    }
}