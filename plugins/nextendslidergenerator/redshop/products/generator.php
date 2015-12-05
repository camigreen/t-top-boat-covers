<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.smartslider.generator_abstract');

class NextendGeneratorredshop_products extends NextendGeneratorAbstract {

    var $extraFields;

    function NextendGeneratorredshop_products($data) {
        parent::__construct($data);
        $this->extraFields = array();
        $this->_variables = array(
            'product_id' => NextendText::_('ID_of_the_product'),
            'title' => NextendText::_('Name_of_the_product'),
            'price' => NextendText::_('Price_of_the_product'),
            'url' => NextendText::_('Url_of_the_product'),
            'short_description' => NextendText::_('Short_description_of_the_product'),
            'description' => NextendText::_('Description_of_the_product'),

            'category_id' => NextendText::_('Id_of_the_product_s_category'),
            'category_name' => NextendText::_('Name_of_the_product_s_category'),
            'category_short_description' => NextendText::_('Short_description_of_the_product_s_category'),
            'category_description' => NextendText::_('Description_of_the_product_s_category'),
            'category_url' => NextendText::_('Url_to_the_product_s_category'),

            'man_name' => NextendText::_('Name_of_the_product_s_manufacturer'),

            'image' => NextendText::_('Image_for_the_product'),
            'thumbnail' => NextendText::_('Image_for_the_product')
        );
    }

    function getData($number) {

        nextendimport('nextend.database.database');
        $db = NextendDatabase::getInstance();
        
        require_once JPATH_ADMINISTRATOR . '/components/com_redshop/helpers/redshop.cfg.php';
        require_once JPATH_ADMINISTRATOR . '/components/com_redshop/helpers/configuration.php';
        require_once JPATH_ADMINISTRATOR . '/components/com_redshop/helpers/template.php';
        require_once JPATH_ADMINISTRATOR . '/components/com_redshop/helpers/stockroom.php';
        require_once JPATH_ADMINISTRATOR . '/components/com_redshop/helpers/economic.php';
        require_once JPATH_SITE . '/components/com_redshop/helpers/product.php';
        
        $Redconfiguration = new Redconfiguration;

        $data = array();
        
        $where = array();
        
        $category = array_map('intval', explode('||', $this->_data->get('redshopproductssourcecategory', '')));
        if (!in_array(0, $category) && count($category) > 0) {
            $where[] = 'pr_cat.category_id IN (' . implode(',', $category) . ') ';
        }
        
        if ($this->_data->get('redshopproductssourcepublished', 1)) {
            $where[] = ' pr.published = 1 ';
        }

        if ($this->_data->get('redshopproductssourcespecial', 0)) {
            $where[] = ' (pr.product_special =  1) ';
        }

        if ($this->_data->get('redshopproductssourceonsale', 0)) {
            $where[] = ' (pr.product_on_sale =  1) ';
        }
        
        $o = '';
        
        
        $order = NextendParse::parse($this->_data->get('redshopproductsorder1', 'pr.product_name|*|asc'));
        if ($order[0]) {
            $o .= 'ORDER BY ' . $order[0] . ' ' . $order[1] . ' ';
            $order = NextendParse::parse($this->_data->get('redshopproductsorder2', 'pr.product_name|*|asc'));
            if ($order[0]) {
                $o .= ', ' . $order[0] . ' ' . $order[1] . ' ';
            }
        }
        
        $query = "SELECT 
                        pr.product_id, 
                        pr.published, 
                        pr_cat.ordering, 
                        pr.product_name as name, 
                        pr.product_s_desc as short_description, 
                        pr.product_desc as description, 
                        man.manufacturer_name as man_name,
                        pr.product_full_image as image, 
                        pr.product_thumb_image as image_thumbnail, 
                        pr.product_price,
                        cat.category_id,
                        cat.category_name, 
                        cat.category_short_description , 
                        cat.category_description
                    FROM `#__redshop_product` AS pr
                    LEFT JOIN `#__redshop_product_category_xref` AS pr_cat USING (product_id)
                    LEFT JOIN `#__redshop_category` AS cat USING (category_id)
                    LEFT JOIN `#__redshop_manufacturer` AS man USING(manufacturer_id)
                    WHERE pr.product_parent_id=0 ".(count($where) ? ' AND '.implode(' AND ', $where) : '')." ".$o." LIMIT 0, " . $number;

        $db->setQuery($query);
        $result = $db->loadAssocList();
        
        $uri = str_replace(array('http://', 'https://'), '//', NextendUri::getBaseUri());
        for ($i = 0; $i < count($result); $i++) {
            $product = new producthelper;
            
            $result[$i]['title'] = $result[$i]['name'];
            
            $result[$i]['price'] = $product->getProductFormattedPrice($product->getProductPrice($result[$i]['product_id']));

            $result[$i]['addtocart'] = $result[$i]['url'] = 'index.php?option=com_redshop&view=product&pid=' . $result[$i]['product_id'] . '&cid=' . $result[$i]['category_id'];
            $result[$i]['addtocart_label'] = 'View product';
            
            $result[$i]['category_url'] = 'index.php?option=com_redshop&view=category&cid='.$result[$i]['category_id'].'&layout=detail';
            
            $result[$i]['thumbnail'] = $result[$i]['image_thumbnail'] = $uri.REDSHOP_FRONT_IMAGES_ABSPATH . "product/".$result[$i]['image_thumbnail'];
            $result[$i]['image'] = $uri.REDSHOP_FRONT_IMAGES_ABSPATH . "product/".$result[$i]['image'];
        }
        return $result;
    }
}