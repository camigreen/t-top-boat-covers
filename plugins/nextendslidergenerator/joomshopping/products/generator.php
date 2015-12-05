<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.smartslider.generator_abstract');

class NextendGeneratorjoomshopping_products extends NextendGeneratorAbstract {

    var $extraFields;

    function NextendGeneratorjoomshopping_products($data) {
        parent::__construct($data);
        $this->extraFields = array();
        $this->_variables = array(
            'name' => NextendText::_('Name_of_the_product'),
            'image' => NextendText::_('Image_for_the_product'),
            'thumbnail' => NextendText::_('Thumbnail_for_the_product'),
            'short_description' => NextendText::_('Short_description_of_the_product'),
            'url' => NextendText::_('Url_of_the_product'),
            'addtocart' => NextendText::_('Add_to_cart_url_of_the_product'),
            'category_name' => NextendText::_('Name_of_the_product_s_category'),
            'category_url' => NextendText::_('Url_to_the_product_s_category'),
            'price' => NextendText::_('Price_of_the_product'),
            
            'id' => NextendText::_('ID_of_the_product'),
            'ean' => NextendText::_('Product_code'),
            'product_old_price' => NextendText::_('Old_price_of_the_product'),

            'category_id' => NextendText::_('Id_of_the_product_s_category'),
            'category_short_description' => NextendText::_('Short_description_of_the_product_s_category'),
            'category_description' => NextendText::_('Description_of_the_product_s_category'),

            'man_name' => NextendText::_('Name_of_the_product_s_manufacturer'),

            'image_full' => NextendText::_('Full_image_for_the_product'),
            'hits' => NextendText::_('Hits_for_the_product')
        );
    }

    function getData($number) {

        nextendimport('nextend.database.database');
        $db = NextendDatabase::getInstance();
        
        require_once(JPATH_SITE . "/components/com_jshopping/lib/factory.php");
        
        $jshopConfig = JSFactory::getConfig();
        $lang = JSFactory::getLang();
        $session =JFactory::getSession();
        $data = array();
        
        $where = array();
        
        $category = array_map('intval', explode('||', $this->_data->get('joomshoppingproductssourcecategory', '')));
        if (!in_array(0, $category) && count($category) > 0) {
            $where[] = 'pr_cat.category_id IN (' . implode(',', $category) . ') ';
        }
        
        if ($this->_data->get('joomshoppingproductssourcepublished', 1)) {
            $where[] = ' pr.product_publish = 1 ';
        }

        if ($this->_data->get('joomshoppingproductssourceinstock', 0)) {
            $where[] = ' (pr.product_quantity > 0 OR pr.unlimited = 1) ';
        }

        if (($labelid = $this->_data->get('joomshoppingproductssourcelabel', 0))) {
            $where[] = ' pr.label_id = "'.$labelid.'" ';
        }
        
        $o = '';
        
        
        $order = NextendParse::parse($this->_data->get('joomshoppingproductsorder1', 'pr.name|*|asc'));
        if ($order[0]) {
            if($order[0] == 'pr.name') $order[0] = 'pr.`'.$lang->get('name').'`';
            $o .= 'ORDER BY ' . $order[0] . ' ' . $order[1] . ' ';
            $order = NextendParse::parse($this->_data->get('joomshoppingproductsorder2', 'pr.name|*|asc'));
            if ($order[0]) {
                if($order[0] == 'pr.name') $order[0] = 'pr.`'.$lang->get('name').'`';
                $o .= ', ' . $order[0] . ' ' . $order[1] . ' ';
            }
        }
        
        $query = "SELECT 
                        pr.product_id, 
                        pr.product_publish, 
                        pr_cat.product_ordering, 
                        pr.`".$lang->get('name')."` as name, 
                        pr.`".$lang->get('short_description')."` as short_description, 
                        man.`".$lang->get('name')."` as man_name, 
                        pr.product_ean as ean, 
                        pr.product_quantity as qty, 
                        pri.image_name as image, 
                        pr.product_price,
                        pr.currency_id, 
                        pr.hits, 
                        pr.unlimited, 
                        pr.product_date_added, 
                        pr.label_id, 
                        pr.vendor_id, 
                        V.f_name as v_f_name, 
                        V.l_name as v_l_name,
                        cat.category_image,
                        cat.category_id,
                        cat.`".$lang->get('name')."` as category_name, 
                        cat.`".$lang->get('alias')."` as category_alias, 
                        cat.`".$lang->get('short_description')."` as category_short_description, 
                        cat.`".$lang->get('description')."` as category_description
                    FROM `#__jshopping_products` AS pr
                    LEFT JOIN `#__jshopping_products_to_categories` AS pr_cat USING (product_id)
                    LEFT JOIN `#__jshopping_categories` AS cat USING (category_id)
                    LEFT JOIN `#__jshopping_manufacturers` AS man ON pr.product_manufacturer_id=man.manufacturer_id
                    LEFT JOIN `#__jshopping_vendors` as V on pr.vendor_id=V.id
                    LEFT JOIN `#__jshopping_products_images` as pri on pr.product_id=pri.product_id
                    WHERE pr.parent_id=0 ".(count($where) ? ' AND '.implode(' AND ', $where) : '')." GROUP BY pr.product_id ".$o." LIMIT 0, " . $number;

        $db->setQuery($query);
        $result = $db->loadAssocList();

        for ($i = 0; $i < count($result); $i++) {
            $product = JTable::getInstance('product', 'jshop');
            $product->load($result[$i]['product_id']);
            
            $attr = JRequest::getVar("attr");
            $back_value = $session->get('product_back_value');        
            if (!isset($back_value['pid'])) $back_value = array('pid'=>null, 'attr'=>null, 'qty'=>null);
            if ($back_value['pid']!=$product_id) $back_value = array('pid'=>null, 'attr'=>null, 'qty'=>null);
            if (!is_array($back_value['attr'])) $back_value['attr'] = array();
            if (count($back_value['attr'])==0 && is_array($attr)) $back_value['attr'] = $attr;
            $attributesDatas = $product->getAttributesDatas($back_value['attr']);
            $product->setAttributeActive($attributesDatas['attributeActive']);
            
            getDisplayPriceForProduct($product->product_price);
            $product->getExtendsData();
            
            $result[$i]['title'] = $result[$i]['name'];
            
            $result[$i]['price'] = formatprice($product->getPriceCalculate());
            $op = $product->getOldPrice();
            $result[$i]['product_old_price'] = $op > 0 ? formatprice($op) : '';

            $result[$i]['url'] = SEFLink('index.php?option=com_jshopping&controller=product&task=view&product_id=' . $result[$i]['product_id'] . '&category_id=' . $result[$i]['category_id']);
            $result[$i]['category_url'] = SEFLink('index.php?option=com_jshopping&controller=category&task=view&category_id=' . $result[$i]['category_id']);
            $result[$i]['addtocart'] = $result[$i]['add_to_cart_url'] = SEFLink('index.php?option=com_jshopping&controller=cart&task=add&quantity=1&to=cart&product_id=' . $result[$i]['product_id'] . '&category_id=' . $result[$i]['category_id']);
            $result[$i]['addtocart_label'] = 'Add to cart';
            
            $result[$i]['image_full'] = $jshopConfig->image_product_live_path.'/full_'.$result[$i]['image'];
            $result[$i]['thumbnail'] = $result[$i]['image_thumb'] = $jshopConfig->image_product_live_path.'/thumb_'.$result[$i]['image'];
            $result[$i]['image'] = $jshopConfig->image_product_live_path.'/'.$result[$i]['image'];            
        } 
        return $result;
    }
}