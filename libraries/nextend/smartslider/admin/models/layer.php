<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.admin.models.base');

class NextendSmartsliderAdminModelLayer extends NextendSmartsliderAdminModelBase {

    function renderForm($data = array()) {

        $css = NextendCss::getInstance();
        $js = NextendJavascript::getInstance();

        $css->addCssLibraryFile('common.css');
        $css->addCssLibraryFile('window.css');
        $css->addCssLibraryFile('configurator.css');

        $configurationXmlFile = dirname(__FILE__) . '/forms/layer.xml';
        $js->loadLibrary('dojo');

        nextendimport('nextend.form.form');
        $form = new NextendForm();
        $form->loadArray($data);

        $form->loadXMLFile($configurationXmlFile);

        echo $form->render('layer');
    }
}

