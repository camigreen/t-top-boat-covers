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
    if (!$api_key || !$api_secret || !$redirect_uri) {
        $api_key = isset($_SESSION['api_key']) ? $_SESSION['api_key'] : null;
        $api_secret = isset($_SESSION['api_secret']) ? $_SESSION['api_secret'] : null;
        $redirect_uri = isset($_SESSION['redirect_uri']) ? $_SESSION['redirect_uri'] : null;
    } else {
        $_SESSION['api_key'] = $api_key;
        $_SESSION['api_secret'] = $api_secret;
        $_SESSION['redirect_uri'] = $redirect_uri;
    }

    if ($api_key && $api_secret) {
        require_once(dirname(__FILE__) . "/api/facebook.php");

        $facebook = new Facebook(array(
            'appId' => $api_key,
            'secret' => $api_secret,
        ));

        $user = $facebook->getUser();

        if (!$user) {
            header('Location: ' . $facebook->getLoginUrl(array('redirect_uri' => $redirect_uri, 'scope' => 'user_photos')));
            exit;
        } else {
            $facebook->setExtendedAccessToken();
            $accessToken = $facebook->getAccessToken();
            $facebook->destroySession();
            unset($_SESSION['api_key']);
            unset($_SESSION['api_secret']);
            unset($_SESSION['redirect_uri']);
            echo '<script type="text/javascript">';
            echo 'window.opener.setToken("' . $accessToken . '");';
            echo '</script>';
        }

    }
}