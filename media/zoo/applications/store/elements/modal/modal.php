<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');


/*
	Class: ElementModal
		The modal element class
*/
class ElementModal extends ElementStore {
    

        public function __construct() {
            parent::__construct();
        }
	/*
	   Function: edit
	       Renders the edit form field.

	   Returns:
	       String - html
	*/
	public function edit($params = array())
        {
           return false; 
	}

        public function render($params = array(), $published = true) {
                $table = $this->app->table->item;
                $name = str_replace('_','-',strtolower($this->config->get('element_id')));
                $db   = $this->app->database;
                $date = $this->app->date->create();
                $now  = $db->Quote($date->toSQL());
                $null = $db->Quote($db->getNullDate());
                $conditions = ' alias = "'.$name.'"'
                            .($published ? ' AND state = 1'
                            .' AND '.$this->app->user->getDBAccessString()
                            .' AND (publish_up = '.$null.' OR publish_up <= '.$now.')'
                            .' AND (publish_down = '.$null.' OR publish_down >= '.$now.')' : '');
                $modal = $table->find('first',compact('conditions'));
                if(!isset($modal)) {
                    return false;
                }
                $renderer = $this->app->renderer->create('item')->addPath(array($this->app->path->path('component.site:'), $modal->getApplication()->getTemplate()->getPath()));
                $modal = $renderer->render('item.modal.full', array('item' => $modal, 'params' => $params));
                
                return $modal;
        }
        
        
        public function hasValue($params = array()) {
            return true;
        }
        

}