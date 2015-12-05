<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author Shawn
 */
class Store {
    
    
    public function formatCurrency($value) {
        $value = (float)$value;
        return '$'.number_format($value, 2, '.', '');
    }
    public function array2object($array) {
        $obj = new stdClass();
        foreach((array)$array as $key => $value) {
            $obj->$key = (is_array($value) ? $this->array2object($value) : $value);
        }
        return $obj;
    }
    
    protected function _parse($resource) {

	    // init vars
		$parts     = explode(':', $resource);
		$count     = count($parts);
		$namespace = null;
                $key = null;

		// parse resource path
		if ($count == 1) {
			list($namespace) = $parts;
		} elseif ($count == 2) {
			list($namespace, $key) = $parts;
		}

		return compact('namespace', 'key');
    }
    public function set($resource, $value) {
        $parts = explode(':',$resource);
        $result = $this;
        $i = 1;
        $count = count($parts);
        foreach($parts as $part) {
            if ($i == $count) {
                $result->$part = $value;
                continue;
            }
            switch (gettype($result)) {
                case 'object':
                    $result = (isset($result->$part) ? $result->$part : null);
                    break;
                case 'array':
                    $result = (isset($result[$part]) ? $result[$part] : null);
                    break;
                default:
                    $result = null;  
            }
            $i++;
        }
        return $this;
    }
    public function get($resource) {
        $parts = explode(':',$resource);
        $result = $this;
        foreach($parts as $part) {
            switch (gettype($result)) {
                case 'object':
                    $result = (isset($result->$part) ? $result->$part : null);
                    break;
                case 'array':
                    $result = (isset($result[$part]) ? $result[$part] : null);
                    break;
                default:
                    $result = null;  
            }
            
        }
        return $result;
    }
    
    public function transfer($obj) {
        return $this->app->data->create($obj);
    }
}
