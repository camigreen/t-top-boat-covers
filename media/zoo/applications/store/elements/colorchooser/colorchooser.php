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
	Class: ElementSelect
		The select element class
*/
class ElementColorChooser extends ElementStore {
    

        protected $colors = array(
            'navy','black','gray','tan'
        );
	public function edit($params = array())
        {

            
            
	}
        
        public function render($params = array()) {

                $fName = $this->config->get('field_name');
                $default = $this->config->get('default');
                $name = $this->config->get('name');
                
                if (!$default) {
                    $chosen_opts[] = $this->app->html->_('select.option', 'X', '-' . JText::_('Select') . '-');
                }
                
                foreach ($this->colors as $key => $value) {
                        
                    $chosen_opts[] = $this->app->html->_('select.option', $value, ucfirst($value));
                 
                }
                $attr = 'class="uk-width-1-1 item-option" data-name="'.$name.'"';
                $dropdown = $this->app->html->_('select.genericlist', $chosen_opts, $fName, $attr, 'value', 'text',$default);

                return $this->renderLayout($this->app->path->path('elements:colorchooser/tmpl/default.php'), compact('fName','dropdown','params'));
           
        }
        
        public function hasValue($params = array()) {
            return true;
        }
        
        public function renderHelper($params = array(), $published = true) {
            if($this->config->get('helper')) {
                $table = $this->app->table->item;
                $name = str_replace('_','-',strtolower($this->config->get('field_name')));
                $db   = $this->app->database;
                $date = $this->app->date->create();
                $now  = $db->Quote($date->toSQL());
                $null = $db->Quote($db->getNullDate());
                $conditions = ' alias = "'.$name.'"'
                            .($published ? ' AND state = 1'
                            .' AND '.$this->app->user->getDBAccessString()
                            .' AND (publish_up = '.$null.' OR publish_up <= '.$now.')'
                            .' AND (publish_down = '.$null.' OR publish_down >= '.$now.')' : '');
                $helper = $table->find('first',compact('conditions'));
                if(!isset($helper)) {
                    return false;
                }
                $renderer = $this->app->renderer->create('item')->addPath(array($this->app->path->path('component.site:'), $helper->getApplication()->getTemplate()->getPath()));
                $modal = $renderer->render('item.helper.full', array('item' => $helper, 'params' => $params));
                
                return $modal;

            }
            return false;
        }


}