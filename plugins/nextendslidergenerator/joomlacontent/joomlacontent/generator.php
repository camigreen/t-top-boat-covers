<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.smartslider.generator_abstract');
require_once(JPATH_SITE . '/components/com_content/helpers/route.php');

class NextendGeneratorJoomlaContent_JoomlaContent extends NextendGeneratorAbstract {

    function NextendGeneratorJoomlaContent_JoomlaContent($data) {
        parent::__construct($data);
        $this->_variables = array(
            'title' => NextendText::_('Title_of_the_article'),
            'image' => '',
            'thumbnail' => '',
            'description' => NextendText::_('Intro_of_the_article'),
            'url' => NextendText::_('Url_of_the_article'),
            'fulltext' => NextendText::_('Text_of_the_article'),
            'cat_title' => NextendText::_('Title_of_the_article_s_category'),
            'categorylisturl' => NextendText::_('Url_to_the_article_s_category_with_list_layout'),
            'categoryblogurl' => NextendText::_('Url_to_the_article_s_category_with_blog_layout'),
            'created_by' => NextendText::_('Id_of_the_article_s_creator'),
            'author_name' => NextendText::_('Name_of_the_article_s_creator'),
            'fulltext_image' => ''
        );
    }

    function getData($number) {

        nextendimport('nextend.database.database');
        $db = NextendDatabase::getInstance();

        $data = array();

        $category = array_map('intval', explode('||', $this->_data->get('sourcecategory', '')));

        $query = 'SELECT ';
        $query .= 'con.id, ';
        $query .= 'con.title, ';
        $query .= 'con.alias, ';
        $query .= 'con.introtext, ';
        $query .= 'con.fulltext, ';
        $query .= 'con.catid, ';
        $query .= 'cat.title AS cat_title, ';
        $query .= 'cat.alias AS cat_alias, ';
        $query .= 'con.created_by, ';
        $query .= 'usr.name AS created_by_alias, ';
        $query .= 'con.images ';

        $query .= 'FROM #__content AS con ';

        $query .= 'LEFT JOIN #__users AS usr ON usr.id = con.created_by ';

        $query .= 'LEFT JOIN #__categories AS cat ON cat.id = con.catid ';


        $query .= 'WHERE con.catid IN (' . implode(',', $category) . ') ';
        $sourceuserid = intval($this->_data->get('sourceuserid', ''));
        if ($sourceuserid) {
            $query .= 'AND con.created_by = '.$sourceuserid.' ';
        }
        if ($this->_data->get('sourcepublished', 1)) {
            $query .= 'AND con.state = 1 ';
            $jnow = JFactory::getDate();
            $now = version_compare(JVERSION,'1.6.0','<') ? $jnow->toMySQL() : $jnow->toSql();
            $query .= "AND (con.publish_up = '0000-00-00 00:00:00' OR con.publish_up < '".$now."') AND (con.publish_down = '0000-00-00 00:00:00' OR con.publish_down > '".$now."') "; 
        }
        if ($this->_data->get('sourcefeatured', 0)) {
            $query .= 'AND con.featured = 1 ';
        }
        $language = $this->_data->get('sourcelanguage', '*');
        if ($language) {
            $query .= 'AND con.language = ' . $db->quote($language) . ' ';
        }

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

        $dispatcher = JDispatcher::getInstance();
        JPluginHelper::importPlugin('content');
        $uri = str_replace(array('http://', 'https://'), '//', NextendUri::getBaseUri());
        for ($i = 0; $i < count($result); $i++) {
            $article = new stdClass();
            $article->text = $result[$i]['introtext'];
            $_p = array();
            $dispatcher->trigger('onContentPrepare', array('com_smartslider2', &$article, &$_p, 0));
            if(!empty($article->text)) $result[$i]['introtext'] = $article->text;
            $result[$i]['description'] = $result[$i]['introtext'];
            
            $article->text = $result[$i]['fulltext'];
            $_p = array();
            $dispatcher->trigger('onContentPrepare', array('com_smartslider2', &$article, &$_p, 0));
            if(!empty($article->text)) $result[$i]['fulltext'] = $article->text;
            
            $result[$i]['url'] = ContentHelperRoute::getArticleRoute($result[$i]['id'].':'.$result[$i]['alias'], $result[$i]['catid'].':'.$result[$i]['cat_alias']);
            $result[$i]['categorylisturl'] = 'index.php?option=com_content&view=category&id=' . $result[$i]['catid'];
            $result[$i]['categoryblogurl'] = 'index.php?option=com_content&view=category&layout=blog&id=' . $result[$i]['catid'];
            $images = (array)json_decode($result[$i]['images'], true);
            $result[$i]['image'] = $result[$i]['thumbnail'] = $result[$i]['intro_image'] = isset($images['image_intro']) ? $uri.$images['image_intro'] : '';
            $result[$i]['fulltext_image'] = isset($images['image_fulltext']) ? $uri.$images['image_fulltext'] : '';
            unset($result[$i]['images']);
            
            $result[$i]['url_label'] = 'View article'; 
            $result[$i]['author_name'] = $result[$i]['created_by_alias']; 
            $result[$i]['author_url'] = '#'; 
        }
        return $result;
    }
}