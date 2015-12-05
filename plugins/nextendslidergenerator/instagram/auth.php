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
        require_once(dirname(__FILE__) . "/api/Instagram.php");

        $config = array(
            'client_id' => $api_key,
            'client_secret' => $api_secret,
            'redirect_uri' => $redirect_uri,
            'grant_type' => 'authorization_code',
        );
        $instagram = new Instagram($config);
        $accessCode = $instagram->getAccessCode();
        if($accessCode === null){
            $instagram->openAuthorizationUrl();
        }else{
            $accessToken = $instagram->getAccessToken();
            unset($_SESSION['api_key']);
            unset($_SESSION['api_secret']);
            unset($_SESSION['redirect_uri']);
            echo '<script type="text/javascript">';
            echo 'window.opener.setToken("'.$accessToken.'");';
            echo '</script>';
        }
    }
}