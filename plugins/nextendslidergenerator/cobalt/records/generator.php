<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php

nextendimport('nextend.smartslider.generator_abstract');

class NextendGeneratorCobalt_Records extends NextendGeneratorAbstract {

    var $extraFields;

    function NextendGeneratorCobalt_Records($data) {
        parent::__construct($data);
        $this->extraFields = array();
        $this->_variables = array(
            'id' => NextendText::_('ID_of_the_record'),
            'title' => NextendText::_('Title_of_the_record'),
            'url' => NextendText::_('Url_of_the_record'),
            'section_id' => NextendText::_('Id_of_the_record_s_section'),
            'section_title' => NextendText::_('Title_of_the_record_s_section'),
            'section_url' => NextendText::_('Url_to_the_record_s_section'),
            'category_id' => NextendText::_('Id_of_the_record_s_category'),
            'cat_title' => NextendText::_('Title_of_the_record_s_category'),
            'category_url' => NextendText::_('Url_to_the_record_s_category'),
            'type_id' => NextendText::_('Id_of_the_record_s_type'),
            'type_title' => NextendText::_('Title_of_the_record_s_type'),
            'created_by' => NextendText::_('Id_of_the_record_s_creator'),
            'created_by_alias' => NextendText::_('Name_of_the_record_s_creator'),
            'hits' => NextendText::_('Hits_of_the_record')
        );

        $this->loadExtraFields();
        if (count($this->extraFields) > 0) {
            foreach ($this->extraFields AS $v) {
                $this->_variables['extra' . $v['id'] . '_' . preg_replace("/\W|_/", "", $v['label'])] = 'Extra field ' . $v['label'] . ' of the record';
            }
        }
    }

    function loadExtraFields() {
        static $extraFields = null;
        if ($extraFields === null) {
            $db = NextendDatabase::getInstance();

            $query = 'SELECT ';
            $query .= 'field.label, ';
            $query .= 'field.id ';

            $query .= 'FROM #__js_res_fields AS field  ';

            $query .= 'WHERE field.published = 1 ORDER BY id ASC ';

            $db->setQuery($query);
            $this->extraFields = $db->loadAssocList('id');
        }
    }

    function getData($number) {

        nextendimport('nextend.database.database');
        $db = NextendDatabase::getInstance();

        $data = array();

        $section = array_map('intval', explode('||', $this->_data->get('cobaltrecordssourcesection', '')));
        $category = array_map('intval', explode('||', $this->_data->get('cobaltrecordssourcecategory', '')));
        $type = array_map('intval', explode('||', $this->_data->get('cobaltrecordssourcetype', '')));

        $query = 'SELECT ';

        $query .= 'rec.id ';

        $query .= 'FROM #__js_res_record AS rec ';

        $query .= 'LEFT JOIN #__js_res_record_category AS cat ON cat.record_id = rec.id ';

        $where = array();

        if (!in_array(0, $section) && count($section) > 0) {
            $where[] = 'rec.section_id IN (' . implode(',', $section) . ') ';
        }

        if (!in_array(0, $category) && count($category) > 0) {
            $where[] = 'cat.catid IN (' . implode(',', $category) . ') ';
        }

        if (!in_array(0, $type) && count($type) > 0) {
            $where[] = 'rec.type_id IN (' . implode(',', $type) . ') ';
        }

        $sourceuserid = intval($this->_data->get('cobaltrecordssourceuserid', ''));
        if ($sourceuserid) {
            $where[] = ' rec.user_id = ' . $sourceuserid . ' ';
        }

        if ($this->_data->get('cobaltrecordssourcepublished', 1)) {
            $where[] = ' rec.published = 1 ';
        }

        if ($this->_data->get('cobaltrecordssourcefeatured', 0)) {
            $where[] = ' rec.featured = 1 ';
        }
        $language = $this->_data->get('cobaltrecordssourcelanguage', '*');
        if ($language && $language != '*') {
            $where[] = ' rec.langs = ' . $db->quote($language) . ' ';
        }
        if (count($where) > 0) {
            $query .= 'WHERE ' . implode(' AND ', $where) . ' ';
        }

        $order = NextendParse::parse($this->_data->get('cobaltrecordsorder1', 'rec.title|*|asc'));
        if ($order[0]) {
            $query .= 'ORDER BY ' . $order[0] . ' ' . $order[1] . ' ';
            $order = NextendParse::parse($this->_data->get('cobaltrecordsorder2', 'rec.title|*|asc'));
            if ($order[0]) {
                $query .= ', ' . $order[0] . ' ' . $order[1] . ' ';
            }
        }


        $query .= 'LIMIT 0, ' . $number . ' ';

        $db->setQuery($query);
        $ids = $db->loadAssocList();


        require_once JPATH_SITE . '/components/com_cobalt/models/form.php';
        if (version_compare(JVERSION, '2.5.6', 'lt')) {
            jimport('joomla.application.component.model');
        } else {
            jimport('joomla.application.component.modellegacy');
        }
        JLoader::import('record', JPATH_SITE . '/components/com_cobalt/models');

        $model = null;
        if (version_compare(JVERSION, '2.5.6', 'lt')) {
            $model = JModel::getInstance('record', 'CobaltModel');
        } else {
            $model = JModelLegacy::getInstance('record', 'CobaltModel');
        }

        $sectionmodel = null;
        if (version_compare(JVERSION, '2.5.6', 'lt')) {
            $sectionmodel = JModel::getInstance('section', 'CobaltModel');
        } else {
            $sectionmodel = JModelLegacy::getInstance('section', 'CobaltModel');
        }

        $categorymodel = null;
        if (version_compare(JVERSION, '2.5.6', 'lt')) {
            $categorymodel = JModel::getInstance('category', 'CobaltModel');
        } else {
            $categorymodel = JModelLegacy::getInstance('category', 'CobaltModel');
        }

        $data = array();
        foreach ($ids AS $id) {
            $r = array();
            $rec = $model->_prepareItem($model->getItem($id['id']));
            $r['id'] = $rec->id;
            $r['title'] = $rec->title;
            $r['url'] = $rec->url;
            $r['hits'] = $rec->hits;
            $r['created_by'] = $rec->user_id;
            $user = JFactory::getUser($r['created_by']);
            $r['created_by_alias'] = $user->get('name');
            $r['section_id'] = $rec->section_id;

            $section = $sectionmodel->getItem($r['section_id']);

            $r['section_title'] = $section->name;
            $r['section_url'] = Url::records($section);

            $r['category_id'] = $rec->category_id;
            $category = $categorymodel->getItem($r['category_id']);
            $r['cat_title'] = $category->title;
            $r['category_url'] = Url::records($section, $category);

            $r['type_id'] = $rec->type_id;
            $r['type_title'] = $rec->type_name;

            if (is_array($rec->fields_by_id) && count($rec->fields_by_id) > 0) {
                foreach ($rec->fields_by_id AS $id => $field) {
                    $r['extra' . $id . '_' . preg_replace("/\W|_/", "", $field->getLabelName())] = $field->result;
                }
            }

            $data[] = $r;
        }

        return $data;
    }
}