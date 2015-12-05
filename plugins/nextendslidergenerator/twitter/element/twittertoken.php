<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.form.element.text');

class NextendElementTwitterToken extends NextendElementText {

    function fetchElement() {
        $js = NextendJavascript::getInstance();
        $js->addLibraryJsAssetsFile('dojo', 'element.js');
        $js->addLibraryJsFile('dojo', dirname(__FILE__).'/twittertoken.js');
        $js->addLibraryJs('dojo', '
            new NextendElementTwitterToken({
              hidden: "' . $this->_id . '",
              hidden2: "' . $this->_id . 'secret",
              link: "nextend-twitter-request-token",
              callback: "nextend-twitter-callback",
              folder: "'.NextendFilesystem::pathToRelativePath(realpath(dirname(__FILE__).'/..')).'/'.'"
            });
        ');
        $html = parent::fetchElement();

        $html.='<a href="#" id="nextend-twitter-request-token" style="line-height: 24px;">'.NextendText::_('Request_token').'</a>';

        $html.='<span id="nextend-twitter-callback" style="line-height: 24px;clear: both;float:left;"></span>';

        return $html;
    }
}
