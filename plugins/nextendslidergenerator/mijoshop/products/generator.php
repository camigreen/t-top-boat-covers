<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.smartslider.generator_abstract');

class NextendGeneratorMijoshop_Products extends NextendGeneratorAbstract {

    var $extraFields;

    function NextendGeneratorMijoshop_Products($data) {
        parent::__construct($data);
        $this->extraFields = array();
        $this->_variables = array(
            'title' => NextendText::_('Name_of_the_product'),
            'image' => NextendText::_('Image_for_the_product'),
            'thumbnail' => NextendText::_('Image_for_the_product'),
            'short_description' => NextendText::_('Description_of_the_product'),
            'url' => NextendText::_('Url_of_the_product'),
            'addtocart' => NextendText::_('Url_of_the_product'),
            'sku' => NextendText::_('SKU_of_the_product'),
            'model' => NextendText::_('Model_of_the_product'),
            'quantity' => NextendText::_('Quantity_of_the_product'),
            'manufacturer' => NextendText::_('Name_of_the_product_s_manufacturer'),

            'price' => NextendText::_('Price_for_the_product'),
            'price_ex_tax' => NextendText::_('Price_excluded_tax'),
            'special_price' => NextendText::_('Special_price')
        );
    }

    function getData($number) {

        nextendimport('nextend.database.database');
        $db = NextendDatabase::getInstance();

        $data = array();
        
        require_once(JPATH_ROOT . '/components/com_mijoshop/mijoshop/mijoshop.php');
        
        $config = MijoShop::get('opencart')->get('config');
        $currency = MijoShop::get('opencart')->get('currency');
        
        /*if(MijoShop::get('base')->isAdmin('joomla')) {
            global $vqmod;
            if (empty($vqmod)) {
                require_once(JPATH_MIJOSHOP_OC.'/vqmod/vqmod.php');
                $vqmod = new VQMod();
            }
            require_once($vqmod->modCheck(DIR_SYSTEM . 'library/tax.php'));
            MijoShopOpencart::$tax = new Tax(MijoShopOpencart::$registry);
            MijoShopOpencart::$registry->set('tax', MijoShopOpencart::$tax);
        }*/
        
        $tax = MijoShop::get('opencart')->get('tax');
        $router = MijoShop::get('router');

        $language_id = intval($this->_data->get('mijoshopproductssourcelanguage'));
        if(!$language_id) $language_id = intval($config->get('config_language_id'));
        
        $tmpLng = $config->get('config_language_id');
        $config->set('config_language_id', $language_id);
        
        MijoShopOpencart::$loader->model('catalog/product');
        $p = new ModelCatalogProduct(MijoShopOpencart::$registry);
        
        $query = 'SELECT ';
        $query.= 'p.product_id ';
        $query .= 'FROM #__mijoshop_product AS p ';
        
        $query.= 'LEFT JOIN #__mijoshop_product_description AS pc USING(product_id) ';
        $query.= 'LEFT JOIN #__mijoshop_product_to_category AS ptc USING(product_id) ';
        $query.= 'LEFT JOIN #__mijoshop_product_special AS ps USING(product_id) ';
         
        $where = array();
        
        $category = array_map('intval', explode('||', $this->_data->get('mijoshopproductssourcecategory', '')));

        if (!in_array(0, $category) && count($category) > 0) {
            $where[] = 'ptc.category_id IN (' . implode(',', $category) . ') ';
        }

        if ($this->_data->get('mijoshopproductssourcepublished', 1)) {
            $where[] = ' p.status = 1 ';
        }

        if ($this->_data->get('mijoshopproductssourcespecial', 0)) {
            $where[] = ' ps.price IS NOT NULL';
            
            $jnow = JFactory::getDate();
            $now = version_compare(JVERSION,'1.6.0','<') ? $jnow->toMySQL() : $jnow->toSql();
            
            $where[] = ' (ps.date_start = "0000-00-00" OR ps.date_start < \''.$now.'\')';
            $where[] = ' (ps.date_end = "0000-00-00" OR ps.date_end > \''.$now.'\')';
        }

        if ($this->_data->get('mijoshopproductssourceinstock', 0)) {
            $where[] = ' p.quantity > 0 ';
        }
        
        $where[] = ' pc.language_id  = '.$language_id; 
        
        if (count($where) > 0) {
            $query .= 'WHERE ' . implode(' AND ', $where) . ' ';
        }
        
        $query .= 'GROUP BY p.product_id ';
        
        $order = NextendParse::parse($this->_data->get('mijoshopproductsorder1', 'pc.name|*|asc'));
        if ($order[0]) {
            $query .= 'ORDER BY ' . $order[0] . ' ' . $order[1] . ' ';
            $order = NextendParse::parse($this->_data->get('mijoshopproductsorder2', '|*|asc'));
            if ($order[0]) {
                $query .= ', ' . $order[0] . ' ' . $order[1] . ' ';
            }
        }
        $query .= 'LIMIT 0, ' . $number;
	

        $db->setQuery($query);
        $result = $db->loadAssocList();

        for ($i = 0; $i < count($result); $i++) {
            
            $pi = $p->getProduct($result[$i]['product_id']);
            
            $data[$i] = array();
            
            $data[$i]['title'] = $data[$i]['name'] = $pi['name'];
            $data[$i]['short_description'] = html_entity_decode($pi['description']);
            $data[$i]['model'] = $pi['model'];
            $data[$i]['sku'] = $pi['sku'];
            $data[$i]['quantity'] = $pi['quantity'];
            $data[$i]['manufacturer'] = $pi['manufacturer'];
            $data[$i]['rating'] = $pi['rating'];
            
            
            //$data[$i]['price'] = $currency->format($tax->calculate($pi['price'], $pi['tax_class_id'], $config->get('config_tax')));
	    $data[$i]['price'] = $pi['price'];
    						
    			  if ((float)$product_info['special']) {
    				    $data[$i]['special_price'] = $currency->format($tax->calculate($pi['special'], $pi['tax_class_id'], $config->get('config_tax')));
            }else{
                $data[$i]['special_price'] = '';
            }
    
    			
      			if ($config->get('config_tax')) {
      				  $data[$i]['price_ex_tax'] = $currency->format((float)$pi['special'] ? $pi['special'] : $pi['price']);
            }
            $data[$i]['thumbnail'] = $data[$i]['image'] = NextendFilesystem::pathToAbsoluteURL(DIR_IMAGE).$pi['image'];
            $data[$i]['addtocart'] = $data[$i]['url'] = str_replace("administrator/", "", $router->route('index.php?option=com_mijoshop&route=product/product&product_id=' . $pi['product_id']));             
            $data[$i]['addtocart_label'] = 'View product';
	    
	    $query="SELECT name FROM #__mijoshop_category_description WHERE category_id = (SELECT category_id FROM #__mijoshop_product_to_category WHERE product_id = ".$result[$i]['product_id']." LIMIT 1)";
	    $db->setQuery($query);
	    $cat_result = $db->loadAssocList();
            
            $data[$i]['category_name'] = $cat_result[0]['name'];
            $data[$i]['category_url'] = '#';
        }
                
        $config->set('config_language_id', $tmpLng);
        
        return $data;
    }
}