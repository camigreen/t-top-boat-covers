<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('_JEXEC') or die('Restricted access');
/**
 * Description of StoreElement
 *
 * @author Shawn
 */
class ElementStore extends Element {
    
    public function hasModal($params = array(), $field_name = null, $published = true) {
                $table = $this->app->table->item;
                $name = ($field_name ? str_replace('_','-',strtolower($field_name)) : str_replace('_','-',strtolower($this->config->get('field_name'))));
                $db   = $this->app->database;
                $date = $this->app->date->create();
                $now  = $db->Quote($date->toSQL());
                $null = $db->Quote($db->getNullDate());
                $conditions = ' alias = "'.$name.'"'
                            .' AND type = "modal"'
                            .($published ? ' AND state = 1'
                            .' AND '.$this->app->user->getDBAccessString()
                            .' AND (publish_up = '.$null.' OR publish_up <= '.$now.')'
                            .' AND (publish_down = '.$null.' OR publish_down >= '.$now.')' : '');
                $modal = $table->find('first',compact('conditions'));
                if (isset($modal)) {
                    $modal_name = $name.'-modal';
                    $modal_link = '<a href="#'.$modal_name.'"class="uk-icon-button uk-icon-info-circle" style="margin-left:10px;" data-uk-tooltip title="Click here for more info!" data-uk-modal></a>';
                    return $modal_link;
                    
                }
                return false;
        }
    
    public function edit() {
        parent::edit();
    }
    
}
