<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

function nextend_api_auth_flow() {
    $api_key = NextendRequest::getVar('api_key');
    $api_secret = NextendRequest::getVar('api_secret');
    $redirect_uri = NextendRequest::getVar('redirect_uri');

    if (session_id() == "") {
        @session_start();
    }
    if(!$api_key || !$api_secret || !$redirect_uri){
        $api_key = isset($_SESSION['api_key']) ? $_SESSION['api_key'] : null;
        $api_secret = isset($_SESSION['api_secret']) ? $_SESSION['api_secret'] : null;
        $redirect_uri = isset($_SESSION['redirect_uri']) ? $_SESSION['redirect_uri'] : null;
    }else{
        $_SESSION['api_key'] = $api_key;
        $_SESSION['api_secret'] = $api_secret;
        $_SESSION['redirect_uri'] = $redirect_uri;
    }

    if ($api_key && $api_secret) {
        if (!class_exists('Google_Client')) require_once dirname(__FILE__) . '/googleclient/Google_Client.php';
        if (!class_exists('Google_YouTubeService')) require_once dirname(__FILE__) . '/googleclient/contrib/Google_YouTubeService.php';

        $client = new Google_Client();
        $client->setClientId($api_key);
        $client->setClientSecret($api_secret);
        $client->setRedirectUri($redirect_uri);
        $client->setApprovalPrompt('auto');
        $client->setAccessType('offline');
        $youtube = new Google_YouTubeService($client);

        
        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $accessToken = $client->getAccessToken();
            unset($_SESSION['api_key']);
            unset($_SESSION['api_secret']);
            unset($_SESSION['redirect_uri']);
            echo '<script type="text/javascript">';
            echo 'window.opener.setToken(\''.$accessToken.'\');';
            echo '</script>';
        }else{
            $authUrl = $client->createAuthUrl();
            header('LOCATION: '.$authUrl);
        }
    }
}