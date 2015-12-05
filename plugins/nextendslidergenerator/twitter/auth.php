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
        require_once(dirname(__FILE__) . "/api/tmhOAuth.php");
        
        $tmhOAuth = new tmhOAuth(array(
          'consumer_key'    => $api_key,
          'consumer_secret' => $api_secret,
        ));
        
        if(isset($_REQUEST['oauth_verifier'])) {
            $tmhOAuth->config['user_token'] = $_SESSION['t_oauth']['oauth_token'];
            $tmhOAuth->config['user_secret'] = $_SESSION['t_oauth']['oauth_token_secret'];
            $code = $tmhOAuth->request('POST', $tmhOAuth->url('oauth/access_token', '') , array(
              'oauth_verifier' => $_REQUEST['oauth_verifier']
            ));
            
            
            if ($code == 200) {
                $access_token = $tmhOAuth->extract_params($tmhOAuth->response['response']);
                unset($_SESSION['api_key']);
                unset($_SESSION['api_secret']);
                unset($_SESSION['redirect_uri']);
                unset($_SESSION['t_oauth']);
                
                echo '<script type="text/javascript">';
                echo 'window.opener.setToken("'.$access_token['oauth_token'].'", "'.$access_token['oauth_token_secret'].'");';
                echo '</script>';
            }else{
                echo '<h3>Error</h3><br />';
                echo $tmhOAuth->response['response'];
                exit;
            }
        }else{
            $code = $tmhOAuth->request('POST', $tmhOAuth->url('oauth/request_token', '') , array(
              'oauth_callback' => $redirect_uri
            ));
            if ($code == 200) {
                $oauth = $tmhOAuth->extract_params($tmhOAuth->response['response']);
                $_SESSION['t_oauth'] = $oauth;
                $authurl = $tmhOAuth->url("oauth/authenticate", '') . "?oauth_token=".$oauth['oauth_token']."&force_login=1";
                header('Location: ' . $authurl);
                exit;
            }else{
                echo '<h3>Error</h3><br />';
                echo $tmhOAuth->response['response'];
                exit;
            }
        }
    }
}