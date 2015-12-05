<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.smartslider.generator_abstract');

class NextendGeneratorEasyBlog_Posts extends NextendGeneratorAbstract {

    var $extraFields;

    function NextendGeneratorEasyBlog_Posts($data) {
        parent::__construct($data);
        $this->_variables = array(
            "title" => NextendText::_('The_title_of_the_post'),
            "image" => NextendText::_('URL_of_the_image_that_is_associated_with_your_blog_post_Suggested_to_insert_as_an_image_item'),
            "thumbnail" => NextendText::_('URL_of_the_thumbnail_of_image_that_is_associated_with_your_blog_post_Suggested_to_insert_as_an_image_item'),
            
            "description" => NextendText::_('The_main_part_of_the_post_If_there_is_no_Read_more_section_this_contains_the_entire_post_otherwise_it_contains_the_intro_part_of_it'),
            "url" => NextendText::_('URL_of_the_current_EasyBlog_post'),
            "rest_of_the_post" => NextendText::_('The_rest_of_the_post_If_the_post_is_divided_by_a_Read_more_tag_this_contains_the_section_placed_after_it_empty_otherwise'),
            "author_name" => NextendText::_('Represents_the_username_of_the_post_creator'),
            "blogger_avatar_picture" => NextendText::_('Contains_the_URL_of_the_blogger_s_avatar_picture_Suggested_to_insert_as_an_image_item'),
            "cat_title" => NextendText::_('The_title_of_the_EasyBlog_category_that_contains_the_post'),
            "blog_image_icon" => NextendText::_('URL_of_the_icon_of_the_image_that_is_associated_with_your_blog_post_Suggested_to_insert_as_an_image_item'),
            "categoryurl" => NextendText::_('URL_of_the_category_By_navigating_there_EasyBlog_is_going_to_list_all_the_posts_this_category_contains')
        );
    }

    function getData($number) {

        nextendimport('nextend.database.database');
        $db = NextendDatabase::getInstance();

        $data = array();

        $category = array_map('intval', explode('||', $this->_data->get('easyblogcategories', '')));

        $query = 'SELECT con.*, con.intro as "main_content_of_post", con.content as "rest_of_the_post", usr.nickname as "blogger", usr.avatar as "blogger_avatar_picture", cat.title as cat_title ';

        /* id 	created_by 	title 	description 	alias 	avatar 	parent_id 	private 	created 	status 	published 	ordering 	level 	lft 	rgt 	default */

        $query .= 'FROM #__easyblog_post con ';

        $query .= 'LEFT JOIN #__easyblog_users usr ON usr.id = con.created_by ';

        $query .= 'LEFT JOIN #__easyblog_category cat ON cat.id = con.category_id ';

        $query .= 'WHERE con.category_id IN (' . implode(',', $category) . ') ';

        if ($this->_data->get('easyblogpublished', 1)) {
            $jnow = JFactory::getDate();
            $now = version_compare(JVERSION, '1.6.0', '<') ? $jnow->toMySQL() : $jnow->toSql();
            $query .= "AND con.published = 1 AND (con.publish_up = '0000-00-00 00:00:00' OR con.publish_up < '" . $now . "') AND (con.publish_down = '0000-00-00 00:00:00' OR con.publish_down > '" . $now . "') ";
        }

        if ($this->_data->get('easyblogfrontpage', 1)) {
            $query .= "AND con.frontpage = " . $this->_data->get('easyblogfrontpage', 1) . " ";
        }

        $sourceuserid = intval($this->_data->get('easybloguserid', ''));
        if ($sourceuserid) {
            $query .= 'AND con.created_by = ' . $sourceuserid . ' ';
        }

        $order = NextendParse::parse($this->_data->get('easyblogorder1', 'con.title|*|asc'));
        if ($order[0]) {
            $query .= 'ORDER BY ' . $order[0] . ' ' . $order[1] . ' ';
            $order = NextendParse::parse($this->_data->get('easyblogorder2', 'con.title|*|asc'));
            if ($order[0]) {
                $query .= ', ' . $order[0] . ' ' . $order[1] . ' ';
            }
        }

        $query .= 'LIMIT 0, ' . $number . ' ';

        $db->setQuery($query);
        $result = $db->loadAssocList();

        for ($i = 0; $i < count($result); $i++) {
            $result[$i]['url'] = 'index.php?option=com_easyblog&view=entry&id=' . $result[$i]['id'];
            $result[$i]['categoryurl'] = 'index.php?option=com_easyblog&view=categories&id=' . $result[$i]['category_id'];
            $result[$i]['blogger_avatar_picture'] = ($result[$i]['blogger_avatar_picture'] == "default_blogger.png" ? "components/com_easyblog/assets/images/" . $result[$i]['blogger_avatar_picture'] : "images/easyblog/avatar/" . $result[$i]['blogger_avatar_picture']);
            $img = json_decode($result[$i]["image"], true);
            if (is_array($img)) {
                if (isset($img["url"])) {
                    $result[$i]['blog_image'] = $img["url"];
                } else
                    $result[$i]['blog_image'] = "";
                if (isset($img["icon"]) && isset($img["icon"]["url"])) {
                    $result[$i]['blog_image_icon'] = $img["icon"]["url"];
                } else
                    $result[$i]['blog_image_icon'] = "";
                if (isset($img["thumbnail"]) && isset($img["thumbnail"]["url"])) {
                    $result[$i]['blog_image_thumbnail'] = $img["thumbnail"]["url"];
                } else
                    $result[$i]['blog_image_thumbnail'] = $result[$i]['blog_image'];
                    
                $result[$i]['image'] = $result[$i]['blog_image'];
                $result[$i]['thumbnail'] = $result[$i]['blog_image_thumbnail'];
            }
            $result[$i]['description'] = $result[$i]['main_content_of_post'];
            $result[$i]['url_label'] = 'View post';
            $result[$i]['author_name'] = $result[$i]['blogger'];
            $result[$i]['author_url'] = '#';
        }
        return $result;
    }

}