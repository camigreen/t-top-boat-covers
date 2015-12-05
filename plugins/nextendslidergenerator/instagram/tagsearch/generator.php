<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.generator_abstract');

class NextendGeneratorInstagram_TagSearch extends NextendGeneratorAbstract {

    function NextendGeneratorInstagram_TagSearch($data) {
        parent::__construct($data);
        $this->_variables = array(
            'title' => NextendText::_('Caption_of_the_image'),
            'image' => NextendText::_('Url_of_the_photo'),
            'thumbnail' => NextendText::_('Thumbnail_image_url'),
            'url' => NextendText::_('Website_of_the_photo_s_owner'),
            'author_name' => NextendText::_('Full_name_of_the_photo_s_owner'),
            'author_url' => NextendText::_('Website_of_the_photo_s_owner'),
            
            'low_res_image' => NextendText::_('Low_resolution_image_url'),
            'owner_username' => NextendText::_('Username_of_the_photo_s_owner'),
            'owner_website' => NextendText::_('Website_of_the_photo_s_owner'),
            'owner_profile_picture' => NextendText::_('Profile_picture_of_the_photo_s_owner'),
            'owner_bio' => NextendText::_('Bio_of_the_photo_s_owner'),
            'comment_count' => NextendText::_('Comment_count_on_the_image')
        );
    }

    function getData($number) {
	$data = array();

	$api = getNextendInstagram();
	if (!$api)
	    return $data;

	$instagramtagsearch = explode(',', $this->_data->get('instagramtagsearch', ''));
	$i = 0;

	for ($j = 0; $j < count($instagramtagsearch); $j++) {
	    $result = json_decode($api->getRecentTags($instagramtagsearch[$j]), true);

	    if ($result['meta']['code'] == 200) {
		foreach ($result['data'] AS $image) {
		    if ($image['type'] != 'image')
			continue;		    
		    $data[$i]['title'] = $data[$i]['caption'] = is_array($image['caption']) ? $image['caption']['text'] : '';
		    $data[$i]['image'] = $data[$i]['standard_res_image'] = $image['images']['standard_resolution']['url'];
		    $data[$i]['thumbnail'] = $data[$i]['thumbnail_image'] = $image['images']['thumbnail']['url'];
		    $data[$i]['description'] = 'Description is not available for Intagram images.';
		    $data[$i]['url'] = $image['link'];
		    $data[$i]['url_label'] = 'View image';
		    $data[$i]['author_name'] = $data[$i]['owner_full_name'] = $image['user']['full_name'];
		    $data[$i]['author_url'] = $data[$i]['owner_website'] = ($image['user']['website'] ? $image['user']['website'] : '#');

		    $data[$i]['low_res_image'] = $image['images']['low_resolution']['url'];
		    $data[$i]['owner_username'] = $image['user']['username'];
		    $data[$i]['owner_profile_picture'] = $image['user']['profile_picture'];
		    $data[$i]['owner_bio'] = $image['user']['bio'];
		    $data[$i]['comment_count'] = $image['comments']['count'];
		    $i++;
		}
	    }
	}
	return $data;
    }
}