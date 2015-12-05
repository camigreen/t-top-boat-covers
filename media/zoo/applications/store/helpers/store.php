<?php defined('_JEXEC') or die('Restricted access');

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
class StoreHelper extends AppHelper {
    
    
    public function __construct($app) {
        parent::__construct($app);
        
        $app->loader->register('StoreItem','classes:storeitem.php');
    }
    
    public function create($item) {
        
        $class = str_replace('-','',$item->type).'item';
        
        if (file_exists($this->app->path->path('classes:'.basename($class,'item').'.php'))) {
            $this->app->loader->register($class, 'classes:'.basename($class,'item').'.php');
        } else {
            $class = 'StoreItem';
        }
        
        $object = new $class($this->app, $item);
        
        return $object;
    }
    
}
