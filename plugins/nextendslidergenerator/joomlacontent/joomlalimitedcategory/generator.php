<?php

/*
  # author Roland Soos
  # copyright Copyright (C) Nextendweb.com. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
?><?php

nextendimport('nextend.smartslider.generator_abstract');

class NextendGeneratorJoomlaContent_JoomlaLimitedCategory extends NextendGeneratorAbstract {

    function NextendGeneratorJoomlaContent_JoomlaLimitedCategory($data) {
	parent::__construct($data);
	$this->_variables = array(
	    'id' => NextendText::_('ID_of_the_category'),
	    'title' => NextendText::_('Title_of_the_category'),
	    'url' => NextendText::_('Url_of_the_category_with_list_layout'),
	    'url_blog' => NextendText::_('Url_of_the_category_with_blog_layout'),
	    'alias' => NextendText::_('Alias_of_the_category'),
	    'description' => NextendText::_('Description_of_the_category'),
	    'image' => NextendText::_('Image_of_the_category'),
	    'parent_id' => NextendText::_('ID_of_the_parent_category'),
	    'parent_title' => NextendText::_('Title_of_the_parent_category'),
	    'parent_url' => NextendText::_('Url_of_the_parent_category_with_list_layout'),
	    'parent_url_blog' => NextendText::_('Url_of_the_parent_category_with_blog_layout'),
	);
    }

    function getData($number) {

	nextendimport('nextend.database.database');
	$db = NextendDatabase::getInstance();

	$data = array();

	$category = array_map('intval', explode('||', $this->_data->get('sourcecategory', '')));

	$limit = intval($this->_data->get('generatorgroup', '1'));

	if ($this->_data->get('sourcelimit', '0')) {

	    $i = 0;

	    for ($j = 0; $j < count($category); $j++) {

		$query = 'SELECT ';
		$query .= 'cat.id, ';
		$query .= 'cat.title, ';
		$query .= 'cat.alias, ';
		$query .= 'cat.description, ';
		$query .= 'cat.params, ';
		$query .= 'cat_parent.id AS parent_id, ';
		$query .= 'cat_parent.title AS parent_title ';

		$query .= 'FROM #__categories AS cat ';

		$query .= 'LEFT JOIN #__categories AS cat_parent ON cat_parent.id = cat.parent_id ';


		$query .= 'WHERE cat.parent_id IN (' . $category[$j] . ') ';

		if ($this->_data->get('sourcepublished', 1)) {
		    $query .= 'AND cat.published = 1 ';
		}
		$language = $this->_data->get('sourcelanguage', '*');
		if ($language) {
		    $query .= 'AND cat.language = ' . $db->quote($language) . ' ';
		}

		$order = NextendParse::parse($this->_data->get('joomlacartegoryorder1', 'cat.title|*|asc'));
		if ($order[0]) {
		    $query .= 'ORDER BY ' . $order[0] . ' ' . $order[1] . ' ';
		    $order = NextendParse::parse($this->_data->get('joomlacartegoryorder2', '|*|asc'));
		    if ($order[0]) {
			$query .= ', ' . $order[0] . ' ' . $order[1] . ' ';
		    }
		}


		$query .= 'LIMIT ' . $limit;

		$db->setQuery($query);
		$result = $db->loadAssocList();

		$dispatcher = JDispatcher::getInstance();
		JPluginHelper::importPlugin('content');
		$uri = str_replace(array('http://', 'https://'), '//', NextendUri::getBaseUri());
		for ($i = 0; $i < $limit; $i++) {
		    $article = new stdClass();
		    $article->text = $result[$i]['description'];
		    $_p = array();
		    $dispatcher->trigger('onContentPrepare', array('com_smartslider2', &$article, &$_p, 0));
		    if (!empty($article->text))
			$result[$i]['description'] = $article->text;
		    if (isset($result[$i]['id'])) {
			$result[$i]['url'] = 'index.php?option=com_content&view=category&id=' . $result[$i]['id'];
			$result[$i]['url_blog'] = 'index.php?option=com_content&view=category&layout=blog&id=' . $result[$i]['id'];
		    }
		    $params = (array) json_decode($result[$i]['params'], true);
		    $result[$i]['image'] = isset($params['image']) ? $uri . $params['image'] : '';
		    if ($result[$i]['parent_title'] != 'ROOT' && isset($result[$i]['id'])) {
			$result[$i]['parent_url'] = 'index.php?option=com_content&view=category&id=' . $result[$i]['parent_id'];
			$result[$i]['parent_url_blog'] = 'index.php?option=com_content&view=category&layout=blog&id=' . $result[$i]['parent_id'];
		    } else {
			$result[$i]['parent_title'] = '';
			$result[$i]['parent_url'] = '';
			$result[$i]['parent_url_blog'] = '';
		    }
		}
		$data = array_merge($data, $result);
	    }
	    return $data;
	} else {
	    $query = 'SELECT ';
	    $query .= 'cat.id, ';
	    $query .= 'cat.title, ';
	    $query .= 'cat.alias, ';
	    $query .= 'cat.description, ';
	    $query .= 'cat.params, ';
	    $query .= 'cat_parent.id AS parent_id, ';
	    $query .= 'cat_parent.title AS parent_title ';

	    $query .= 'FROM #__categories AS cat ';

	    $query .= 'LEFT JOIN #__categories AS cat_parent ON cat_parent.id = cat.parent_id ';


	    $query .= 'WHERE cat.parent_id IN (' . implode(',', $category) . ') ';

	    if ($this->_data->get('sourcepublished', 1)) {
		$query .= 'AND cat.published = 1 ';
	    }
	    $language = $this->_data->get('sourcelanguage', '*');
	    if ($language) {
		$query .= 'AND cat.language = ' . $db->quote($language) . ' ';
	    }

	    $order = NextendParse::parse($this->_data->get('joomlacartegoryorder1', 'cat.title|*|asc'));
	    if ($order[0]) {
		$query .= 'ORDER BY ' . $order[0] . ' ' . $order[1] . ' ';
		$order = NextendParse::parse($this->_data->get('joomlacartegoryorder2', '|*|asc'));
		if ($order[0]) {
		    $query .= ', ' . $order[0] . ' ' . $order[1] . ' ';
		}
	    }

	    $db->setQuery($query);
	    $result = $db->loadAssocList();

	    $dispatcher = JDispatcher::getInstance();
	    JPluginHelper::importPlugin('content');
	    $uri = str_replace(array('http://', 'https://'), '//', NextendUri::getBaseUri());
	    for ($i = 0; $i < count($result); $i++) {
		$article = new stdClass();
		$article->text = $result[$i]['description'];
		$_p = array();
		$dispatcher->trigger('onContentPrepare', array('com_smartslider2', &$article, &$_p, 0));
		if (!empty($article->text))
		    $result[$i]['description'] = $article->text;

		$result[$i]['url'] = 'index.php?option=com_content&view=category&id=' . $result[$i]['id'];
		$result[$i]['url_blog'] = 'index.php?option=com_content&view=category&layout=blog&id=' . $result[$i]['id'];
		$params = (array) json_decode($result[$i]['params'], true);
		$result[$i]['image'] = isset($params['image']) ? $uri . $params['image'] : '';
		if ($result[$i]['parent_title'] != 'ROOT') {
		    $result[$i]['parent_url'] = 'index.php?option=com_content&view=category&id=' . $result[$i]['parent_id'];
		    $result[$i]['parent_url_blog'] = 'index.php?option=com_content&view=category&layout=blog&id=' . $result[$i]['parent_id'];
		} else {
		    $result[$i]['parent_title'] = '';
		    $result[$i]['parent_url'] = '';
		    $result[$i]['parent_url_blog'] = '';
		}
	    }

	    return $result;
	}
    }

}
