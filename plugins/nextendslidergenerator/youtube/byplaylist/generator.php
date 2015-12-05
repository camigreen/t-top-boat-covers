<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.generator_abstract');

class NextendGeneratorYoutube_ByPlaylist extends NextendGeneratorAbstract {

    function NextendGeneratorYoutube_ByPlaylist($data) {
        parent::__construct($data);
        $this->_variables = array(
            'video_id' => NextendText::_('Use_this_with_Youtube_item_YouTube_video_code'),
            'video_url' => NextendText::_('Url_to_the_video'),
            'title' => NextendText::_('Video_title'),
            'description' => NextendText::_('Video_description'),
            'channel_title' => NextendText::_('Channel_title'),
            'channel_url' => NextendText::_('Url_to_the_channel'),
            'thumbnail_default' => NextendText::_('Default_thumbnail_image'),
            'thumbnail_medium' => NextendText::_('Medium_thumbnail_image'),
            'thumbnail_high' => NextendText::_('High_thumbnail_image')
        );
    }

    function getData($number) {

        $data = array();

        $a = getNextendYoutube();
        if (!$a) return $data;
        $client = $a[0];
        $youtube = $a[1];
        
        $playlist = $this->_data->get('youtubeplaylist', '');
        if($playlist){
            try {
    
                $videos = $youtube->playlistItems->listPlaylistItems('id,snippet', array(
                    'maxResults' => $number,
                    'playlistId' => $playlist
                ));
                $i = 0;
                foreach ($videos['items'] AS $k => $item) {
                    $data[$i] = array();
    
                    $data[$i]['video_id'] = $item['snippet']['resourceId']['videoId'];
                    $data[$i]['video_url'] = 'http://www.youtube.com/watch?v=' . $item['snippet']['resourceId']['videoId'];
                    $data[$i]['title'] = $item['snippet']['title'];
                    $data[$i]['description'] = $item['snippet']['description'];
                    $data[$i]['thumbnail_default'] = $item['snippet']['thumbnails']['default']['url'];
                    $data[$i]['thumbnail_medium'] = $item['snippet']['thumbnails']['medium']['url'];
                    $data[$i]['thumbnail_high'] = $item['snippet']['thumbnails']['high']['url'];
                    $data[$i]['channel_title'] = $item['snippet']['channelTitle'];
                    $data[$i]['channel_url'] = 'http://www.youtube.com/user/' . $item['snippet']['channelTitle'];
                    $i++;
                }
    
            } catch (Google_ServiceException $e) {
                echo sprintf('<p>A service error occurred: <code>%s</code></p>',
                    htmlspecialchars($e->getMessage()));
            }
    
            catch
            (Google_Exception $e) {
                echo sprintf('<p>An client error occurred: <code>%s</code></p>',
                    htmlspecialchars($e->getMessage()));
            }
        }
        return $data;
    }
}