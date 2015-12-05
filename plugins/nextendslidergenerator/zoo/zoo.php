<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimportsmartslider2('nextend.smartslider.check');

class plgNextendSliderGeneratorZoo extends NextendPluginBase {

    var $_group = 'zoo';

    function onNextendSliderGeneratorList(&$group, &$list, $showall = false) {
        if ($showall || smartsliderIsFull()) {

            $installed = NextendFilesystem::existsFolder(JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_zoo');
            if ($installed) {
                $group[$this->_group] = 'ZOO';

                if (!isset($list[$this->_group]))
                    $list[$this->_group] = array();

                require_once(JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_zoo' . DIRECTORY_SEPARATOR . 'config.php');
                $zoo = App::getInstance('zoo');

                $apps = $zoo->table->application->all(array('order' => 'name'));

                require_once($this->getPath() . 'items' . DIRECTORY_SEPARATOR . 'generator.php');

                foreach ($apps AS $app) {
                    foreach ($app->getTypes() AS $type) {
                        //Make them class name safe
                        $appid = preg_replace('/[^a-zA-Z0-9_\x7f-\xff]*/', '', $app->id);
                        $identifier = preg_replace('/[^a-zA-Z0-9_\x7f-\xff]*/', '', $type->identifier);
                        $list[$this->_group][$this->_group . '_items__' . $appid . '___' . $identifier] = array(ucfirst($app->name) . ' (' . ucfirst($type->identifier) . ')', $this->getPath() . 'items' . DIRECTORY_SEPARATOR, true, true, $installed ? true : 'http://extensions.joomla.org/extensions/authoring-a-content/content-construction/12479', null);
                        if(!class_exists('NextendGeneratorZoo_items__' . $appid . '___' . $identifier)){
                            eval('class NextendGeneratorZoo_items__' . $appid . '___' . $identifier . ' extends NextendGeneratorZoo_Items{}');
                        }
                    }
                }
            } else if ($showall) {
                $group[$this->_group] = 'ZOO';
                if (!isset($list[$this->_group]))
                    $list[$this->_group] = array();
                $list[$this->_group][$this->_group . '_items'] = array('Zoo', $this->getPath() . 'items' . DIRECTORY_SEPARATOR, true, true, 'http://extensions.joomla.org/extensions/authoring-a-content/content-construction/12479', null);
            }
            $app = JFactory::getApplication();
            if ($app->isAdmin() && ((NextendRequest::getVar('action') == 'createdynamic' || NextendRequest::getVar('action') == 'generatorsettings') && NextendRequest::getVar('group') == 'zoo' && NextendRequest::getVar('type'))) {
                $class = 'NextendGenerator' . NextendRequest::getVar('type');
                $data = new NextendData();
                $data->set('source', NextendRequest::getVar('type'));
                new $class($data);
            }
        }
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR;
    }

}

NextendPlugin::addPlugin('nextendslidergenerator', 'plgNextendSliderGeneratorZoo');
