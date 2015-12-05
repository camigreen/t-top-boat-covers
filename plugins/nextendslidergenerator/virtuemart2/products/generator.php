<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.smartslider.generator_abstract');

class NextendGeneratorVirtuemart2_Products extends NextendGeneratorAbstract {

    var $extraFields;

    function NextendGeneratorVirtuemart2_Products($data) {
        parent::__construct($data);
        $this->extraFields = array();
        $this->_variables = array(
            'id' => NextendText::_('ID_of_the_product'),
            'sku' => NextendText::_('SKU_of_the_product'),
            'title' => NextendText::_('Name_of_the_product'),
            'url' => NextendText::_('Url_of_the_product'),
            'short_description' => NextendText::_('Short_description_of_the_product'),
            'description' => NextendText::_('Description_of_the_product'),
            'slug' => NextendText::_('Slug_of_the_product'),

            'category_id' => NextendText::_('Id_of_the_product_s_category'),
            'category_name' => NextendText::_('Name_of_the_product_s_category'),
            'category_description' => NextendText::_('Description_of_the_product_s_category'),
            'category_slug' => NextendText::_('Slug_of_the_product_s_category'),
            'category_url' => NextendText::_('Url_to_the_product_s_category'),

            'manufacturer_id' => NextendText::_('Id_of_the_product_s_manufacturer'),
            'manufacturer_name' => NextendText::_('Name_of_the_product_s_manufacturer'),
            'manufacturer_email' => NextendText::_('Email_of_the_product_s_manufacturer'),
            'manufacturer_description' => NextendText::_('Description_of_the_product_s_manufacturer'),
            'manufacturer_url' => NextendText::_('Url_to_the_product_s_manufacturer'),
            'manufacturer_slug' => NextendText::_('Slug_of_the_product_s_manufacturer'),

            'image' => NextendText::_('Image_for_the_product'),
            'thumbnail' => NextendText::_('Thumbnail_for_the_product'),
            'hits' => NextendText::_('Hits_of_the_product'),
            'price' => NextendText::_('Cost_price'),
            'cost_price' => NextendText::_('Cost_price'),
            'base_price' => NextendText::_('Base_price'),
            'base_price_variant' => NextendText::_('Base_price_variant'),
            'base_price_with_tax' => NextendText::_('Base_price_with_tax'),
            'discounted_price_without_tax' => NextendText::_('Discounted_price_without_tax'),
            'price_before_tax' => NextendText::_('Price_before_tax'),
            'sales_price' => NextendText::_('Sales_price'),
            'tax_amount' => NextendText::_('Tax_amount'),
            'sales_price_with_discount' => NextendText::_('Sales_price_with_discount'),
            'sales_price_temp' => NextendText::_('Sales_price_temp'),
            'unit_price' => NextendText::_('Unit_price'),
            'price_without_tax' => NextendText::_('Price_without_tax'),
            'discount_amount' => NextendText::_('Discount_amount'),
            'variant_modification' => NextendText::_('Variant_modification')
        );
    }

    function getData($number) {

        nextendimport('nextend.database.database');
        $db = NextendDatabase::getInstance();

        if (!class_exists( 'VmConfig' )) require_once(JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_virtuemart' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'config.php');
        VmConfig::loadConfig();


        $language = $this->_data->get('virtuemartproductssourcelanguage', 'en_gb');
        if (!$language) $language = VMLANG;

        $data = array();

        $category = array_map('intval', explode('||', $this->_data->get('virtuemartproductssourcecategory', '')));

        $query = 'SELECT ';
        $query .= 'prod.virtuemart_product_id AS id, ';
        $query .= 'prod.product_sku AS sku, ';
        $query .= 'prod_ext.product_name AS name, ';
        $query .= 'prod_ext.product_s_desc AS short_description, ';
        $query .= 'prod_ext.product_desc AS description, ';
        $query .= 'prod_ext.slug AS slug, ';

        $query .= 'cat.virtuemart_category_id AS category_id, ';
        $query .= 'cat.category_name, ';
        $query .= 'cat.category_description, ';
        $query .= 'cat.slug AS category_slug, ';

        $query .= 'man.virtuemart_manufacturer_id AS manufacturer_id, ';
        $query .= 'man.mf_name AS manufacturer_name, ';
        $query .= 'man.mf_email AS manufacturer_email, ';
        $query .= 'man.mf_desc AS manufacturer_description, ';
        $query .= 'man.mf_url AS manufacturer_url, ';
        $query .= 'man.slug AS manufacturer_slug, ';

        $query .= 'med.file_url AS image, ';
        $query .= 'med.file_url_thumb AS thumbnail, ';

        $query .= 'prod.hits ';


        $query .= 'FROM #__virtuemart_products AS prod ';

        $query .= 'LEFT JOIN #__virtuemart_products_' . $language . ' AS prod_ext ON prod.virtuemart_product_id = prod_ext.virtuemart_product_id ';

        $query .= 'LEFT JOIN #__virtuemart_product_categories AS cat_x ON cat_x.virtuemart_product_id = prod.virtuemart_product_id ';

        $query .= 'LEFT JOIN #__virtuemart_categories_' . $language . ' AS cat ON cat_x.virtuemart_category_id = cat.virtuemart_category_id ';

        $query .= 'LEFT JOIN #__virtuemart_product_manufacturers AS man_x ON man_x.virtuemart_product_id = prod.virtuemart_product_id ';

        $query .= 'LEFT JOIN #__virtuemart_manufacturers_' . $language . ' AS man ON man_x.virtuemart_manufacturer_id = man.virtuemart_manufacturer_id ';

        $query .= 'LEFT JOIN #__virtuemart_product_medias AS med_x ON med_x.virtuemart_product_id = prod.virtuemart_product_id ';

        $query .= 'LEFT JOIN #__virtuemart_medias AS med ON med_x.virtuemart_media_id = med.virtuemart_media_id ';


        $where = array();

        if (!in_array(0, $category) && count($category) > 0) {
            $where[] = 'cat_x.virtuemart_category_id IN (' . implode(',', $category) . ') ';
        }

        if ($this->_data->get('virtuemartproductssourcepublished', 1)) {
            $where[] = ' prod.published = 1 ';
        }

        if ($this->_data->get('virtuemartproductssourcespecial', 0)) {
            $where[] = ' prod.product_special = 1 ';
        }

        if ($this->_data->get('virtuemartproductssourceinstock', 0)) {
            $where[] = ' prod.product_in_stock > 0 ';
        }

        $where[] = ' med.file_is_downloadable = 0 ';
        $where[] = ' med.file_is_forSale = 0 ';

        if (count($where) > 0) {
            $query .= 'WHERE ' . implode(' AND ', $where) . ' ';
        }

                $order = NextendParse::parse($this->_data->get('virtuemartproductsorder1', 'prod_ext.product_name|*|asc'));
                if ($order[0]) {
                    $query .= 'ORDER BY ' . $order[0] . ' ' . $order[1] . ' ';
                    $order = NextendParse::parse($this->_data->get('virtuemartproductsorder2', 'prod_ext.product_name|*|asc'));
                    if ($order[0]) {
                        $query .= ', ' . $order[0] . ' ' . $order[1] . ' ';
                    }
                }


        $query .= 'LIMIT 0, ' . $number . ' ';

        $db->setQuery($query);
        $result = $db->loadAssocList();
        require_once(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'currencydisplay.php');
        require_once(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models' . DS . 'product.php');
        $currency = CurrencyDisplay::getInstance();

        for ($i = 0; $i < count($result); $i++) {
            $result[$i]['title'] = $result[$i]['name'];
            $productModel = new VirtueMartModelProduct();
            $p = $productModel->getProduct($result[$i]['id'], TRUE, TRUE, TRUE, 1, 0);
            $result[$i]['price'] = $result[$i]['cost_price'] = $currency->createPriceDiv('costPrice', '', $p->prices, true);
            $result[$i]['base_price'] = $currency->createPriceDiv('basePrice', '', $p->prices, true);
            $result[$i]['base_price_variant'] = $currency->createPriceDiv('basePriceVariant', '', $p->prices, true);
            $result[$i]['base_price_with_tax'] = $currency->createPriceDiv('basePriceWithTax', '', $p->prices, true);
            $result[$i]['discounted_price_without_tax'] = $currency->createPriceDiv('discountedPriceWithoutTax', '', $p->prices, true);
            $result[$i]['price_before_tax'] = $currency->createPriceDiv('priceBeforeTax', '', $p->prices, true);
            $result[$i]['sales_price'] = $currency->createPriceDiv('salesPrice', '', $p->prices, true);
            $result[$i]['tax_amount'] = $currency->createPriceDiv('taxAmount', '', $p->prices, true);
            $result[$i]['sales_price_with_discount'] = $currency->createPriceDiv('salesPriceWithDiscount', '', $p->prices, true);
            $result[$i]['sales_price_temp'] = $currency->createPriceDiv('salesPriceTemp', '', $p->prices, true);
            $result[$i]['unit_price'] = $currency->createPriceDiv('unitPrice', '', $p->prices, true);
            $result[$i]['price_without_tax'] = $currency->createPriceDiv('priceWithoutTax', '', $p->prices, true);
            $result[$i]['discount_amount'] = $currency->createPriceDiv('discountAmount', '', $p->prices, true);
            $result[$i]['variant_modification'] = $currency->createPriceDiv('variantModification', '', $p->prices, true);

            $result[$i]['addtocart'] = $result[$i]['url'] = 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $result[$i]['id'] . '&virtuemart_category_id=' . $result[$i]['category_id'];
            $result[$i]['addtocart_label'] = 'View product';
            $result[$i]['category_url'] = 'index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $result[$i]['category_id'];
            $result[$i]['image'] = JURI::root( false).'/'.$result[$i]['image'];
            $result[$i]['thumbnail'] = JURI::root( false).'/'.$result[$i]['thumbnail'];
        }
        return $result;
    }
}