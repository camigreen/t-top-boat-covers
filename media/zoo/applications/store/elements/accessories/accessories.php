<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

/*
   Class: ElementRelatedCategories
       The category element class
*/
class ElementAccessories extends Element {

	/*
		Function: hasValue
			Checks if the element's value is set.

	   Parameters:
			$params - render parameter

		Returns:
			Boolean - true, on success
	*/
	public function hasValue($params = array()) {
		$categories = $this->app->table->category->getById($this->_getCategoryIds(), true);
		return !empty($categories);
	}

	/*
		Function: render
			Override. Renders the element.

	   Parameters:
            $params - render parameter

		Returns:
			String - html
	*/
	public function render($params = array()) {

		$params = $this->app->data->create($params);
                $categories = $this->app->table->category->getById($this->_getCategoryIds(), true);
                $renderer = $this->app->renderer->create('item')->addPath(array($this->app->path->path('component.site:'), $this->_item->getApplication()->getTemplate()->getPath()));
		
//                $categories = $this->app->table->category->getById($this->get('category', array()), true);
                $layout   = $params->get('layout');
		$output   = array();
                $modal = array();
		foreach ($categories as $category) {   
			$items = isset($items) && is_array($items) ? array_merge($items, $this->_getRelatedItems($category)) : $this->_getRelatedItems($category);    
		}
                foreach ($items as $item) {
			$path   = 'item';
			$prefix = 'item.';
			$type   = $item->getType()->id;
			if ($renderer->pathExists($path.DIRECTORY_SEPARATOR.$type)) {
				$path   .= DIRECTORY_SEPARATOR.$type;
				$prefix .= $type.'.';
			}
                        $storeItem = $this->app->store->create($item);   
                        $modal[$item->id] = $renderer->render($prefix.'.related_modal', array('item' => $item, 'storeItem' => $storeItem, 'layout' => 'related_modal'));
		}
                foreach ($items as $item) {
                    if (in_array($layout, $renderer->getLayouts($path))) {
                                
				$output[] = $renderer->render($prefix.$layout, array('item' => $item, 'modal' => $modal[$item->id]));
			} elseif ($params->get('link_to_item', false) && $item->getState()) {
				$output[] = '<a href="'.$this->app->route->item($item).'" title="'.$item->name.'">'.$item->name.'</a>';
			} else {
				$output[] = $item->name;
			}
                }
		return $this->app->element->applySeparators($params->get('separated_by'), $output);

	}
        
        protected function _getRelatedItems($category) {
            $items = array();
            foreach($category->getItems(true) as $item) {
                $items[$item->id] = $item;
            }
            return $items;
            
        }
        
        protected function _getCategoryIds() {
            if ($ids = $this->get('category', array())) {
                if ($ids[0] != '') {
                    return $ids;
                }
            } else {
                $ids = (array) $this->config->get('category');
            }
            return $ids;
        }
        
        protected function _orderItems($items, $order) {

		// if string, try to convert ordering
		if (is_string($order)) {
			$order = $this->app->itemorder->convert($order);
		}

		$items = (array) $items;
		$order = (array) $order;
		$sorted = array();
		$reversed = false;

		// remove empty values
		$order = array_filter($order);

		// if random return immediately
		if (in_array('_random', $order)) {
			shuffle($items);
			return $items;
		}

		// get order dir
		if (($index = array_search('_reversed', $order)) !== false) {
			$reversed = true;
			unset($order[$index]);
		} else {
			$reversed = false;
		}

		// order by default
		if (empty($order)) {
			return $reversed ? array_reverse($items, true) : $items;
		}

		// if there is a none core element present, ordering will only take place for those elements
		if (count($order) > 1) {
			$order = array_filter($order, create_function('$a', 'return strpos($a, "_item") === false;'));
		}

		if (!empty($order)) {

			// get sorting values
			foreach ($items as $item) {
				foreach ($order as $identifier) {
					if ($element = $item->getElement($identifier)) {
						$sorted[$item->id] = strpos($identifier, '_item') === 0 ? $item->{str_replace('_item', '', $identifier)} : $element->getSearchData();
						break;
					}
				}
			}

			// do the actual sorting
			$reversed ? arsort($sorted) : asort($sorted);

			// fill the result array
			foreach (array_keys($sorted) as $id) {
				if (isset($items[$id])) {
					$sorted[$id] = $items[$id];
				}
			}

			// attach unsorted items
			$sorted += array_diff_key($items, $sorted);

		// no sort order provided
		} else {
			$sorted = $items;
		}

		return $sorted;
	}

	/*
	   Function: _edit
	       Renders the edit form field.
		   Must be overloaded by the child class.

	   Returns:
	       String - html
	*/
	public function edit($params = array()){
		//init vars
		$multiselect = $this->config->get('multiselect', array());

        $options = array();
        if (!$multiselect) {
            $options[] = $this->app->html->_('select.option', '', '-' . JText::_('Select Category') . '-');
        }

		$attribs = ($multiselect) ? 'size="5" multiple="multiple"' : '';

		return $this->app->html->_('zoo.categorylist', $this->app->zoo->getApplication(), $options, $this->getControlName('category', true), $attribs, 'value', 'text', $this->get('category', array()));
	}

	/*
		Function: renderSubmission
			Renders the element in submission.

	   Parameters:
            $params - AppData submission parameters

		Returns:
			String - html
	*/
	public function renderSubmission($params = array()) {
        return $this->edit();
	}

	/*
		Function: validateSubmission
			Validates the submitted element

	   Parameters:
            $value  - AppData value
            $params - AppData submission parameters

		Returns:
			Array - cleaned value
	*/
	public function validateSubmission($value, $params) {
        $options = array('required' => $params->get('required'));
		$messages = array('required' => 'Please choose a related category.');
        $clean = $this->app->validator
				->create('foreach', $this->app->validator->create('string', $options, $messages), $options, $messages)
				->clean($value->get('category'));

        $categories = array_keys($this->_item->getApplication()->getCategories());
        foreach ($clean as $category) {
            if (!empty($category) && !in_array($category, $categories)) {
                throw new AppValidatorException('Please choose a correct category.');
            }
        }

		return array('category' => $clean);
	}

}