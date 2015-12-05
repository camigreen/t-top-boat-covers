<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

class StoreApplication extends Application {
    
    public function __construct() {
        parent::__construct();
        
        $zoo = APP::getInstance('zoo');
        
//        Register Paths
        $path = dirname(__FILE__);
        $zoo->path->register($path.'/elements', 'elements');
        $zoo->path->register($path.'/assets', 'assets');
        $zoo->path->register($path.'/templates/store/assets', 'assets');
        $zoo->path->register($path.'/controllers', 'controllers');
        $zoo->path->register($path.'/prices', 'prices');
        $zoo->path->register($path.'/classes', 'classes');
        $zoo->path->register($path.'/helpers', 'helpers');
        $zoo->path->register($path.'/merchant', 'merchant');
        $zoo->path->register($path.'/site', 'component.site');
        $zoo->path->register($path.'/pdf', 'pdf');
        $zoo->path->register($path.'/tables', 'tables');
        $zoo->path->register($path.'/classes/data', 'data');
        include_once $path.'/vendor/autoload.php';
        
//        Load Classes
        $zoo->loader->register('ElementStore','elements:element/element.php');
        $zoo->loader->register('ElementStore','elements:elementstore/elementstore.php');
        
//        Add CSS
        $zoo->document->addStyleSheet('assets:css/ttop.css');

        
//        Add Scripts
        $zoo->document->addScript('elements:cart/assets/js/storeitem.js');
        
        // test
        
    }
    
    public function dispatch() {
        $view = $this->app->request->get('view','word');
        if ($view == 'store') {
            $this->app->dispatch($view);
        } else {
            $this->app->dispatch('default');
        }
        
    }
}