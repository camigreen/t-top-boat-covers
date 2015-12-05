<?php

/*
  # author Roland Soos
  # copyright Copyright (C) Nextendweb.com. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?><?php

nextendimportsmartslider2('nextend.smartslider.generator_abstract');

class NextendGeneratorFacebook_Albumbyuser extends NextendGeneratorAbstract {

    function NextendGeneratorFacebook_Albumbyuser($data) {
	parent::__construct($data);
	$this->_variables = array(
	    'title' => NextendText::_('Creator_name'),
	    'image' => NextendText::_('Image_original_size'),
	    'thumbnail' => NextendText::_('Image_480_longest_side'),
	    'description' => NextendText::_('Image_description'),
	    'url' => NextendText::_('Url_to_the_image_post'),
	    'author_name' => NextendText::_('Full_name_of_the_photo_s_owner'),
	    'author_url' => NextendText::_('Author url'),
	    'likes' => NextendText::_('Likes_on_the_image'),
	    'comments' => NextendText::_('Comments_on_the_image'),
	    'icon' => NextendText::_('Icon_of_the_image'),
	    'picture' => NextendText::_('Picture_of_the_image'),
	    'source' => NextendText::_('Source_of_the_image'),
	    'image1' => NextendText::_('Image_original_size'),
	    'image2' => NextendText::_('Image_960_longest_side'),
	    'image3' => NextendText::_('Image_720_longest_side'),
	    'image4' => NextendText::_('Image_600_longest_side'),
	    'image5' => NextendText::_('Image_480_longest_side'),
	    'image6' => NextendText::_('Image_320_longest_side'),
	    'image7' => NextendText::_('Image_215_longest_side'),
	    'image8' => NextendText::_('Image_130_longest_side'),
	    'image9' => NextendText::_('Image_75_width')
	);
    }

    function getData($number) {
	$data = array();

	$api = getNextendFacebook();
	if (!$api)
	    return $data;

	$facebookalbumsbyuser = $this->_data->get('facebookalbumsbyuser', '');

	try {
	    //$result = $api->api($facebookalbumsbyuser . '/photos');
	    $result = $api->api($facebookalbumsbyuser . '/photos', array('fields' => array('from', 'images', 'name', 'link', 'likes', 'comments', 'icon', 'picture', 'source')));
	    $i = 0;
	    foreach ($result['data'] AS $post) {
		$data[$i]['author_name'] = $data[$i]['title'] = $data[$i]['from_name'] = $post['from']['name'];
		$data[$i]['image'] = $post['images'][0]['source'];
		$data[$i]['thumbnail'] = $post['images'][count($post['images']) - 1]['source'];
		$data[$i]['description'] = isset($post['name']) ? $this->makeClickableLinks($post['name']) : '';

		$data[$i]['url'] = $data[$i]['link'] = $post['link'];
		$data[$i]['url_label'] = 'View image';

		$data[$i]['author_url'] = 'https://www.facebook.com/' . $post['from']['id'];

		$data[$i]['likes'] = isset($post['likes']) && isset($post['likes']['data']) ? count($post['likes']['data']) : 0;
		$data[$i]['comments'] = isset($post['comments']) && isset($post['comments']['data']) ? count($post['comments']['data']) : 0;

		$data[$i]['icon'] = $post['icon'];
		$data[$i]['picture'] = $post['picture'];
		$data[$i]['source'] = $post['source'];
		$x = 1;
		foreach ($post['images'] AS $img) {
		    if ($x == 2 && $img["height"] < 960 && $img["width"] < 960) {
			$data[$i]['image' . $x] = $img['source'];
			$x++;
		    }
		    $data[$i]['image' . $x] = $img['source'];
		    $x++;
		}
		$i++;
	    }
	} catch (Exception $e) {
	    
	}
	return $data;
    }

    function makeClickableLinks($s) {
	return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $s);
    }

}
