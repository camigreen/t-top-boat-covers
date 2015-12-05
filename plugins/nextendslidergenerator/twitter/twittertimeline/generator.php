<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.generator_abstract');

class NextendGeneratorTwitter_Timeline extends NextendGeneratorAbstract {

    function NextendGeneratorTwitter_Timeline($data) {
        parent::__construct($data);
        $this->_variables = array(
            'author_name' => NextendText::_('Screen_name_of_the_user'),
            'author_url' => NextendText::_('Url_of_the_user'),
            'author_image' => NextendText::_('Image_of_the_user'),
            'message' => NextendText::_('Tweet'),
            'url' => NextendText::_('Url to the tweet'),
            'source' => NextendText::_('Source'),
            'user_name' => NextendText::_('Name_of_the_user'),
            'user_description' => NextendText::_('Description_of_the_user'),
            'user_location' => NextendText::_('Location_of_the_user'),
	    'tweet_image' => 'Image from tweet'
        );
    }

    function getData($number) {
        $data = array();

        $twitter = getNextendTwitter();
        if (!$twitter) return $data;
        $result = $twitter->request('GET', 'https://api.twitter.com/1.1/statuses/user_timeline.json' , array(
            'count' => $number
        ));
        
        if ($result == 200) {
            $result = json_decode($twitter->response['response'], true);
            $i = 0;
            foreach ($result AS $tweet) {
                $data[$i]['author_name'] = $data[$i]['user_screen_name'] = $tweet['user']['screen_name'];
                $data[$i]['author_url'] = $data[$i]['user_url'] = $tweet['user']['url'];
                $data[$i]['author_image'] = $data[$i]['user_image'] = $tweet['user']['profile_image_url_https'];
                $data[$i]['message'] = $data[$i]['tweet'] = $this->makeClickableLinks($tweet['text']);
                $data[$i]['url'] = 'https://twitter.com/'.$tweet['user']['id'].'/status/'.$tweet['id'];
                $data[$i]['url_label'] = 'View tweet';
                
                $data[$i]['source'] = $tweet['source'];
                $data[$i]['userid'] = $tweet['user']['id'];
                $data[$i]['user_name'] = $tweet['user']['name'];
                $data[$i]['user_description'] = $tweet['user']['description'];
                $data[$i]['user_location'] = $tweet['user']['location'];
		$data[$i]['tweet_image'] = $tweet['entities']['media'][0]['media_url'];
                $i++;
            }
        }
        return $data;
    }
    
    function makeClickableLinks($s) {
        return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $s);
    }
}