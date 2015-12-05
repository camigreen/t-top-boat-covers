<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.smartslider.generator_abstract');

class NextendGeneratorZoo_Items extends NextendGeneratorAbstract {

    var $extraFields;

    function NextendGeneratorZoo_Items($data) {
        global $nextendzooapp;
        parent::__construct($data);
        preg_match('/.*?__(.*?)___(.*)/', $data->get('source'), $out);
        $this->appid = intval($out[1]);
        $this->typealias = $out[2];
        
        require_once(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_zoo'.DIRECTORY_SEPARATOR.'config.php');
        $this->zoo = App::getInstance('zoo');
        
        
        $this->extraFields = array();
        $this->_variables = array(
            'name' => NextendText::_('Name_of_the_item'),
            'url' => NextendText::_('Url_of_the_item'),
            'hits' => NextendText::_('Hits_of_the_item')
        );
        
        $this->_fieldVariables = array();
        $nextendzooapp = $this->zoo->table->application->get($this->appid);
        $this->_fieldVariables[$nextendzooapp->alias] = array();
        foreach($nextendzooapp->getTypes() AS $type){
            if($type->identifier != $this->typealias) continue;
            $this->_fieldVariables[$nextendzooapp->alias][$this->typealias] = array();
            foreach($type->getElements() AS $el){
                $this->_fieldVariables[$nextendzooapp->alias][$this->typealias][$el->config->get('type').'_'.$el->identifier] = $el->config->get('name') . ' field ';
            }
        }
    }
    
    function generateList(){
        
        $html = '<h4>Common variables</h4>';
        for($i = 1; $i <= $this->_generatorgroup; $i++){
            $html.= '<p class="nextend-variables">';
            foreach($this->_variables AS $k => $v){
                $html.='<span class="nextend-variable nextend-variable-hastip" title="'.$v.' for '.$i.'. record in group" onClick="selectText(this);">{|'.$k.'-'.$i.'|}</span> ';
            }
            $html.= "</p>";
        }
        $html.='<style>.nextend-variables td{width:50%;}.nextend-variables, .nextend-variables td{line-height: 20px; font-size: 13px; font-family: \'Open Sans\',Arial,sans-serif !important;}.nextend-variable{margin: 0 5px;}</style>';
        
        $html.= '<h4>Type specific variables</h4>';
        foreach($this->_fieldVariables AS $appalias => $app){
            foreach($app AS $typealias => $type){
                for($i = 1; $i <= $this->_generatorgroup; $i++){
                    $html.= '<table class="nextend-variables">';
                    foreach($type AS $k => $v){
                        $html.='<tr><td><span class="nextend-variable" onClick="selectText(this);">{|'.$k.'-'.$i.'|}</span></td><td>'.$v.' for '.$i.'. record in group</td></tr>';
                    }
                    $html.= "</table>";
                }
            }
        }
        
        return $html;
    }

    function getData($number) {
    
        $data = array();
        
        preg_match('/.*?__(.*?)___(.*)/', $this->_data->get('source'), $out);
        $appid = intval($out[1]);
        $typealias = $out[2];
        
        $app = $this->zoo->table->application->get($appid);
        $table = $this->zoo->table->item;
        
        $select = 'a.*';
		    $from = $table->name.' AS a';
        
        $where = array();
        
        $where[] = 'a.application_id = '.$appid;
        $where[] = "a.type = '".$typealias."'";
        $where[] = "a.state = 1";
        
        $now  = $this->zoo->date->create()->toSQL();
		    $null = $this->zoo->database->getNullDate();
        $where[] = "(a.publish_up = '".$null."' OR a.publish_up < '".$now."')";
        $where[] = "(a.publish_down = '".$null."' OR a.publish_down > '".$now."')";
        
        $where[] = 'a.'.$this->zoo->user->getDBAccessString($this->zoo->user->get());
        
        $category = array_map('intval', explode('||', $this->_data->get('zooitemssourcecategories', '0')));
        if ($category && !in_array(0, $category)) {
            $from   .= ' LEFT JOIN '.ZOO_TABLE_CATEGORY_ITEM.' AS ci ON a.id = ci.item_id';
            $where[] = 'ci.category_id IN (' . implode(',', $category) .') ';
        }

        $orderby = '';
        $order = NextendParse::parse($this->_data->get('zooitemsorder1', 'a.name|*|asc'));
        if ($order[0]) {
            $orderby = $order[0] . ' ' . $order[1] . ' ';
            $order = NextendParse::parse($this->_data->get('zooitemsorder2', '|*|asc'));
            if ($order[0]) {
                $orderby .= ', ' . $order[0] . ' ' . $order[1] . ' ';
            }
        }
        
        $options = array(
    			'select' => $select,
    			'from' =>  $from,
    			'conditions' => array(implode(' AND ', $where)),
    			'order' => $orderby,
    			'group' => 'a.id',
          'offset' => 0,
          'limit' => $number
          );
          
        $items = $table->all($options);
        $i = 0;
        
        $types = $app->getTypes();
        
        foreach($items AS $item){
            $data[$i] = array();
            $data[$i]['name'] = $item->name;
            $data[$i]['url'] = $data[$i]['url'] = str_replace("administrator/", "",$this->zoo->route->item($item));
            $data[$i]['hits'] = $item->hits;
            
            foreach($types[$typealias]->getElements() AS $k => $el){
                $el->setItem($item);
                $data[$i][$el->config->get('type').'_'.$k] = $el->render();
            }
            
            $i++;
        }
        
        return $data;
    }
}