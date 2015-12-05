<?php

/*
  # author Roland Soos
  # copyright Copyright (C) Nextendweb.com. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?><?php

nextendimport('nextend.smartslider.generator_abstract');

class NextendGeneratorK2_Categories extends NextendGeneratorAbstract {

    var $extraFields;

    function NextendGeneratorK2_Categories($data) {
	parent::__construct($data);
	$this->extraFields = array();
	$this->_variables = array(
	    'id' => 'ID of the category',
	    'title' => 'Title of the category',
	    'image' => 'Image of the category',
	    'thumbnail' => 'Thumbnail image of the category',
	    'description' => 'Description of the category',
	    'url' => 'URL to the category',
	    'alias' => 'Alias of the category',
	    'parent_id' => 'ID of the parent category',
	    'parenttitle' => 'Title of the parent category',
	    'parentalias' => 'Alias of the parent category',
	    'parentdescription' => 'Description of the parent category',
	    'parentimage' => 'Image of the parent category'
	);

	$this->loadExtraFields();
	if (count($this->extraFields) > 0) {
	    foreach ($this->extraFields AS $v) {
		$this->_variables['extra' . $v['id'] . '_' . preg_replace("/\W|_/", "", $v['group_name'] . '_' . $v['name'])] = 'Extra field ' . $v['name'] . ' of the item';
	    }
	}
    }

    function loadExtraFields() {
	static $extraFields = null;
	if ($extraFields === null) {
	    $db = NextendDatabase::getInstance();

	    $query = 'SELECT ';
	    $query .= 'groups.name AS group_name, ';
	    $query .= 'field.name AS name, ';
	    $query .= 'field.id ';

	    $query .= 'FROM #__k2_extra_fields_groups AS groups ';

	    $query .= 'LEFT JOIN #__k2_extra_fields AS field ON field.group = groups.id ';

	    $query .= 'WHERE field.published = 1 ';

	    $db->setQuery($query);
	    $this->extraFields = $db->loadAssocList('id');
	}
    }

    function getData($number) {

	nextendimport('nextend.database.database');
	$db = NextendDatabase::getInstance();

	$data = array();

	$limit = intval($this->_data->get('generatorgroup', 0));

	$i = 0;

	$category = array_map('intval', explode('||', $this->_data->get('k2itemssourcecategory', '')));

	if ($this->_data->get('k2itemssourcelimit', 0)) {

	    for ($j = 0; $j < count($category); $j++) {

		if ($this->_data->get('k2itemssourcepublished', 1)) {
		    $published = " AND published = 1 ";
		} else {
		    $published = " ";
		}

		$query = "SELECT m.image AS image, m.description AS description, m.id AS id, m.name AS title, m.alias AS alias, m.parent AS parent_id,"
			. " (SELECT name FROM #__k2_categories WHERE id=parent_id) AS parenttitle,"
			. " (SELECT alias FROM #__k2_categories WHERE id=parent_id) AS parentalias,"
			. " (SELECT description FROM #__k2_categories WHERE id=parent_id) AS parentdescription,"
			. " (SELECT image FROM #__k2_categories WHERE id=parent_id) AS parentimage FROM #__k2_categories m WHERE m.parent IN (" . $category[$j] . ") AND trash = '0' " . $published . " LIMIT " . $limit;

		$order = NextendParse::parse($this->_data->get('k2itemsorder1', 'm.ordering|*|asc'));
		if ($order[0]) {
		    $query .= 'ORDER BY ' . $order[0] . ' ' . $order[1] . ' ';
		    $order = NextendParse::parse($this->_data->get('k2itemsorder2', 'm.ordering|*|asc'));
		    if ($order[0]) {
			$query .= ', ' . $order[0] . ' ' . $order[1] . ' ';
		    }
		}

		$db->setQuery($query);
		$result = $db->loadAssocList();

		require_once(JPATH_SITE . '/components/com_k2/helpers/utilities.php');
		require_once(JPATH_SITE . '/components/com_k2/models/item.php');
		$k2item = new K2ModelItem();

		for ($i = 0; $i < $limit; $i++) {
		    if (isset($result[$i]['id'])) {
			$result[$i]['url'] = 'index.php?option=com_k2&view=itemlist&task=category&id=' . $result[$i]['id'] . ':' . $result[$i]['alias'];

			if ($result[$i]['image'] != "")
			    $result[$i]['thumbnail'] = $result[$i]['image'] = "media/k2/categories/" . $result[$i]['image'];
			$result[$i]['parentimage'] = "media/k2/categories/" . $result[$i]['parentimage'];

			$result[$i]['url_label'] = 'View category';			
		    }
		    $result[$i]['author_url'] = '#';
		}
		$data = array_merge($data, $result);
	    }
	    return $data;
	} else {

	    if ($this->_data->get('k2itemssourcepublished', 1)) {
		$published = " AND published = 1 ";
	    } else {
		$published = " ";
	    }

	    $query = "SELECT m.image AS image, m.description AS description, m.id AS id, m.name AS title, m.alias AS alias, m.parent AS parent_id,"
		    . " (SELECT name FROM #__k2_categories WHERE id=parent_id) AS parenttitle,"
		    . " (SELECT alias FROM #__k2_categories WHERE id=parent_id) AS parentalias,"
		    . " (SELECT description FROM #__k2_categories WHERE id=parent_id) AS parentdescription,"
		    . " (SELECT image FROM #__k2_categories WHERE id=parent_id) AS parentimage FROM #__k2_categories m WHERE m.parent IN (" . implode(',', $category) . ") AND trash = '0' " . $published;

	    $order = NextendParse::parse($this->_data->get('k2itemsorder1', 'm.ordering|*|asc'));
	    if ($order[0]) {
		$query .= 'ORDER BY ' . $order[0] . ' ' . $order[1] . ' ';
		$order = NextendParse::parse($this->_data->get('k2itemsorder2', 'm.ordering|*|asc'));
		if ($order[0]) {
		    $query .= ', ' . $order[0] . ' ' . $order[1] . ' ';
		}
	    }

	    $db->setQuery($query);
	    $result = $db->loadAssocList();

	    require_once(JPATH_SITE . '/components/com_k2/helpers/utilities.php');
	    require_once(JPATH_SITE . '/components/com_k2/models/item.php');
	    $k2item = new K2ModelItem();

	    for ($i = 0; $i < count($result); $i++) {
		$result[$i]['url'] = 'index.php?option=com_k2&view=itemlist&task=category&id=' . $result[$i]['id'] . ':' . $result[$i]['alias'];

		if ($result[$i]['image'] != "")
		    $result[$i]['thumbnail'] = $result[$i]['image'] = "media/k2/categories/" . $result[$i]['image'];
		$result[$i]['parentimage'] = "media/k2/categories/" . $result[$i]['parentimage'];

		$result[$i]['url_label'] = 'View category';
		$result[$i]['author_url'] = '#';
	    }
	    return $result;
	}
    }

}
