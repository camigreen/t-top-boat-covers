<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.form.element.list');
nextendimport('nextend.parse.parse');

class NextendElementFacebookAlbumsByPage extends NextendElementList {

    function fetchElement() {

        $v = (array)NextendParse::parse($this->parent->_value);
        $_REQUEST['fbpage'] = $v[0];
        $this->_xml->addChild('option', 'Please choose')->addAttribute('value', 0);

        $js = NextendJavascript::getInstance();
        $js->addLibraryJsAssetsFile('dojo', 'element.js');
        $js->addLibraryJsFile('dojo', dirname(__FILE__) . '/facebookalbumsbypage.js');
        $js->addLibraryJs('dojo', '
            new NextendElementFacebookAlbumsbyPage({
                val: "' . $v[0] . '",
                hidden: "' . $this->parent->_id . '",
                listhidden: "' . $this->_id . '",
                group: "nextendslidergenerator",
                method: "onNextendFacebookPageAlbums"
            });
        ');

        ob_start();
        $list = null;
        NextendPlugin::callPlugin('nextendslidergenerator', 'onNextendFacebookPageAlbums', array(&$list));
        
        if ($list) {
            ob_end_clean();
            if (count($list)) {
                foreach ($list AS $id => $name) {
                    $this->_xml->addChild('option', htmlentities($name))->addAttribute('value', $id);
                }
            }
        }

        $this->_value = $this->_form->get($this->_name, $this->_default);
        $html = parent::fetchElement();

        if (!$list) {
            $html .= ob_get_clean();
        }

        return $html;
    }

}
