<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined ( '_JEXEC' ) or die ();

// Component Helper
jimport ( 'joomla.application.component.helper' );
jimport ( 'joomla.application.categories' );

/**
 * Contact Component Route Helper
 *
 * @static
 *
 *
 * @package Joomla.Site
 * @subpackage com_contact
 * @since 1.5
 */
final class JMapRouteHelper {
	/**
	 * Recursive adjacency list model function to find all cat parents
	 *
	 * @param unknown $option        	
	 * @param string $needles        	
	 * @return NULL
	 */
	protected static function findAllParents($option, $categoryTableName, $categoryParentField, $root, &$allParents, $categoryIdentifier) {
		static $db;
		if (! $db) {
			$db = JFactory::getDbo ();
		}
		
		$query = "SELECT " . $db->quoteName ( $categoryParentField ) . 
				 "\n FROM " . $db->quoteName ( $categoryTableName ) . 
				 "\n WHERE " . $db->quoteName($categoryIdentifier) . " = " . ( int ) $root;
		$hasAParentCatId = $db->setQuery ( $query )->loadResult ();
		if ($hasAParentCatId) {
			$allParents [] = ( int ) $hasAParentCatId;
			self::findAllParents ( $option, $categoryTableName, $categoryParentField, $hasAParentCatId, $allParents, $categoryIdentifier);
		}
		
		return $allParents;
	}
	
	protected static function loadRouteManifests() {
		$directory = JPATH_COMPONENT_ADMINISTRATOR . '/framework/route/manifests/';
		$manifestsArray = array ();
		$iterator = new DirectoryIterator ( $directory );
		foreach ( $iterator as $fileinfo ) {
			if ($fileinfo->isFile () && $fileinfo->getFilename () != 'index.html') {
				// Load the manifest serialized file and assign to local variable
				$manifest = file_get_contents ( $fileinfo->getPathname () );
				$manifestConfiguration = json_decode ( $manifest );
				$componentName = $fileinfo->getBasename ( '.json' );
				$manifestsArray [$componentName] = ( array ) $manifestConfiguration;
				// Cast sublevel object to array
				if(isset($manifestsArray[$componentName]['name_params'])){
					$manifestsArray[$componentName]['name_params'] = (array)$manifestsArray[$componentName]['name_params'];
				}
				if(isset($manifestsArray[$componentName]['additional_custom_fields'])){
					$manifestsArray[$componentName]['additional_custom_fields'] = (array)$manifestsArray[$componentName]['additional_custom_fields'];
				}
			}
		}
		return $manifestsArray;
	}
	
	protected static function findItem($option, $needles, $manifestObject, $thisView) {
		static $lookup;
		static $menuInstance;
		
		// Load menu structure only the first time for the first link
		if (! $menuInstance) {
			$menuInstance = new JMapRouteMenu ();
		}
		
		// Build the lookup array for this component if not exists
		if (! isset ( $lookup [$option] )) {
			$lookup [$option] = array ();
			
			$component = JComponentHelper::getComponent ( $option );
			$items = $menuInstance->getItems ( 'component_id', $component->id );
			foreach ( $items as $item ) {
				// If some extensions does not support view on menu links, fallback on controller
				if(isset ( $item ['query'] ) && !isset ( $item ['query'] ['view'])) {
					$item ['query'] ['view'] = isset($item ['query'] ['controller']) ? $item ['query'] ['controller'] : $thisView;
				}
				
				if (isset ( $item ['query'] ) && isset ( $item ['query'] ['view'] )) {
					$view = $item ['query'] ['view'];
					if (! isset ( $lookup [$option] [$view] )) {
						$lookup [$option] [$view] = array ();
					}
					if (isset ( $item ['query'] ['id'] )) { // ID identifier for single item
						// No override already more specific itemid for a certain language
						if (isset ( $lookup [$option] [$view] [$item ['query'] ['id']] )) {
							$alreadyAssigned = $lookup [$option] [$view] [$item ['query'] ['id']];
							$alreadyAssignedLanguage = $items [$alreadyAssigned] ['language'];
							if ($alreadyAssignedLanguage != '*' && $item ['language'] == '*') {
								continue;
							}
						}
						// Standard assignment using id query identifier
						$lookup [$option] [$view] [$item ['query'] ['id']] = $item ['id'];
					} elseif (isset ( $item ['query'] ['catid'] )) { // CATID identifier for categories
						// No override already more specific itemid for a certain language
						if (isset ( $lookup [$option] [$view] [$item ['query'] ['catid']] )) {
							$alreadyAssigned = $lookup [$option] [$view] [$item ['query'] ['catid']];
							$alreadyAssignedLanguage = $items [$alreadyAssigned] ['language'];
							if ($alreadyAssignedLanguage != '*' && $item ['language'] == '*') {
								continue;
							}
						}
						// Standard assignment using catid query identifier
						$lookup [$option] [$view] [$item ['query'] ['catid']] = $item ['id'];
					}  elseif (isset ( $item ['query'] ['cid'] )) { // CID identifier for categories
						// No override already more specific itemid for a certain language
						if (isset ( $lookup [$option] [$view] [$item ['query'] ['cid']] )) {
							$alreadyAssigned = $lookup [$option] [$view] [$item ['query'] ['cid']];
							$alreadyAssignedLanguage = $items [$alreadyAssigned] ['language'];
							if ($alreadyAssignedLanguage != '*' && $item ['language'] == '*') {
								continue;
							}
						}
						// Standard assignment using catid query identifier
						$lookup [$option] [$view] [$item ['query'] ['cid']] = $item ['id'];
					}  elseif (isset ( $item ['query'] ['cat'] )) { // CAT identifier for categories
						// No override already more specific itemid for a certain language
						if (isset ( $lookup [$option] [$view] [$item ['query'] ['cat']] )) {
							$alreadyAssigned = $lookup [$option] [$view] [$item ['query'] ['cat']];
							$alreadyAssignedLanguage = $items [$alreadyAssigned] ['language'];
							if ($alreadyAssignedLanguage != '*' && $item ['language'] == '*') {
								continue;
							}
						}
						// Standard assignment using catid query identifier
						$lookup [$option] [$view] [$item ['query'] ['cat']] = $item ['id'];
					} elseif (isset($manifestObject['holdon_params']) && isset($manifestObject['name_params'][$view])) {
						// Try to guess an id param called = view name in the params json serialized for the menu
						$menuParams = json_decode ( $item ['params'] );
						if(isset($menuParams->{$manifestObject['name_params'][$view]})) {  // CUSTOM identifier for categories
							// Add lookups for both single or multiple view params ids
							if(is_array($menuParams->{$manifestObject['name_params'][$view]})) {
								foreach ($menuParams->{$manifestObject['name_params'][$view]} as $id) {
									// No override already more specific itemid for a certain language
									if (isset ( $lookup [$option] [$view] [$id] )) {
										$alreadyAssigned = $lookup [$option] [$view] [$id];
										$alreadyAssignedLanguage = $items [$alreadyAssigned] ['language'];
										if ($alreadyAssignedLanguage != '*' && $item ['language'] == '*') {
											continue;
										}
									}
									// Standard assignment using custom query identifier
									$lookup [$option] [$view] [$id] = $item ['id'];
								}
							} else {
								// No override already more specific itemid for a certain language
								if (isset ( $lookup [$option] [$view] [$menuParams->{$manifestObject['name_params'][$view]}] )) {
									$alreadyAssigned = $lookup [$option] [$view] [$menuParams->{$manifestObject['name_params'][$view]}];
									$alreadyAssignedLanguage = $items [$alreadyAssigned] ['language'];
									if ($alreadyAssignedLanguage != '*' && $item ['language'] == '*') {
										continue;
									}
								}
								// Standard assignment using custom query identifier
								$lookup [$option] [$view] [$menuParams->{$manifestObject['name_params'][$view]}] = $item ['id'];
							}
						} else {
							// Assign directly to view array name, as a view of fallback categories/frontpage/main entrypoint
							$lookup [$option] [$view] [] = $item ['id'];  // NO identifier found for the view, fallback to view generic scope
						}
					} elseif (isset($manifestObject['name_params'][$view])) {
						$customField = $manifestObject['name_params'][$view];
						if(isset($item ['query'] [$customField])) {  // CUSTOM identifier for categories
							// No override already more specific itemid for a certain language
							if (isset($item ['query'] [$customField]) && isset ( $lookup [$option] [$view] [$item ['query'] [$customField]] )) {
								$alreadyAssigned = $lookup [$option] [$view] [$item ['query'] [$customField]];
								$alreadyAssignedLanguage = $items [$alreadyAssigned] ['language'];
								if ($alreadyAssignedLanguage != '*' && $item ['language'] == '*') {
									continue;
								}
							}
							// Standard assignment using catid query identifier
							$lookup [$option] [$view] [$item ['query'] [$customField]] = $item ['id'];
						} else {
							// Assign directly to view array name, as a view of fallback categories/frontpage/main entrypoint
							$lookup [$option] [$view] [] = $item ['id'];  // NO identifier found for the view, fallback to view generic scope
						}
					}  elseif (isset($manifestObject['additional_custom_fields'][$view])) {
						$customField = $manifestObject['additional_custom_fields'][$view];
						if(isset($item ['query'] [$customField])) {  // CUSTOM identifier for generic elements in the query string not in params used when in params is also active
							// No override already more specific itemid for a certain language
							if (isset($item ['query'] [$customField]) && isset ( $lookup [$option] [$view] [$item ['query'] [$customField]] )) {
								$alreadyAssigned = $lookup [$option] [$view] [$item ['query'] [$customField]];
								$alreadyAssignedLanguage = $items [$alreadyAssigned] ['language'];
								if ($alreadyAssignedLanguage != '*' && $item ['language'] == '*') {
									continue;
								}
							}
							// Standard assignment using catid query identifier
							$lookup [$option] [$view] [$item ['query'] [$customField]] = $item ['id'];
						} else {
							// Assign directly to view array name, as a view of fallback categories/frontpage/main entrypoint
							$lookup [$option] [$view] [] = $item ['id'];  // NO identifier found for the view, fallback to view generic scope
						}
					} else {
						// Assign directly to view array name, as a view of fallback categories/frontpage/main entrypoint
						$lookup [$option] [$view] [] = $item ['id'];  // NO identifier found for the view, fallback to view generic scope
					}
				}
			}
		}
		
		// Search the specific link needles against the lookup array previously built to find an Itemid match
		if ($needles) {
			foreach ( $needles as $view => $ids ) {
				if (isset ( $lookup [$option] [$view] )) {
					foreach ( $ids as $id ) {
						if (isset ( $lookup [$option] [$view] [$id] )) {
							return $lookup [$option] [$view] [$id];
						}
						if (isset ( $lookup [$option] [$view] [0] ) && $id === - 1) {
							return $lookup [$option] [$view] [0];
						}
					}
				}
			}
		} else {
			// No Itemid match found, fallback on current menu Itemid of JSitemap generation, won't work and will be unuseful, use the manual dropdown system :(
			$active = $menus->getActive ();
			if ($active) {
				return $active ['id'];
			}
		}
		
		return null;
	}
	
	/**
	 *
	 * @param
	 *        	int	The route of the newsfeed
	 */
	public static function getItemRoute($option, $thisView, $id, $elm, $mainTable) {
		static $manifests;
		
		if (! $manifests) {
			$manifests = self::loadRouteManifests ();
		}
		if (! array_key_exists ( $option, $manifests )) {
			return false;
		}
		
		// Cover cases when view name is not set and used by component links BUT is always set in the menu links and so for Lookup array
		if(!$thisView) {
			// Orphan view detected, help rescue view to find a match!
			$rescueViewsMapping = $manifests[$option]['views_rescue'];
			foreach ($rescueViewsMapping as $checkValue=>$view) {
				if(property_exists($elm, $checkValue)) {
					$thisView = $view;
					break;
				}
			}
		}
		
		// By default the needle is the exact view for this item, valid for items and categories itself
		if ($id) {
			$needles = array (
					$thisView => array (
							( int ) $id 
					) 
			);
			
			// Are we dealing with a view for items that are categories itself?
			if (preg_match ( '/categor|cats|catg/i', $mainTable )) {
				// Find all parents category if supported
				if(isset($manifests [$option] ['categories_parent_id'])) {
					$categoryIdentifier = isset($manifests[$option]['categories_table_id_field']) ? $manifests[$option]['categories_table_id_field'] : 'id';
					$parentCats = array ();
					$parentCats = self::findAllParents ( $option, $manifests [$option] ['categories_table'], $manifests [$option] ['categories_parent_id'], $id, $parentCats, $categoryIdentifier);
					if (! empty ( $parentCats )) {
						$needles [$thisView] = array_merge ( $needles [$thisView], $parentCats );
					}
				}
			}
		}
		
		// If there is also a categorization and catid add more needles as fallback
		$catid = isset ( $elm->jsitemap_category_id ) ? $elm->jsitemap_category_id : null;
		if ($catid) {
			$needles ['category'] = array (
					( int ) $catid 
			);
			
			// Not casted to int, compatibility with slug as for Docman
			$needles ['list'] = array (
					$catid 
			);
			
			// Add if any additional custom components categories views
			if(isset($manifests [$option] ['additional_categories_needles'])) {
				$needles [$manifests [$option] ['additional_categories_needles']] = array (
						( int ) $catid
				);
			}
			
			// Find all parents category if supported
			if(isset($manifests [$option] ['categories_parent_id'])) {
				$categoryIdentifier = isset($manifests[$option]['categories_table_id_field']) ? $manifests[$option]['categories_table_id_field'] : 'id';
				$parentCats = array ();
				$parentCats = self::findAllParents ( $option, $manifests [$option] ['categories_table'], $manifests [$option] ['categories_parent_id'], $catid, $parentCats, $categoryIdentifier );
				if (! empty ( $parentCats )) {
					$needles ['category'] = array_merge ( $needles ['category'], $parentCats );
					$needles ['list'] = $needles ['category'];
					// Check if custom categories views are set and so update them also
					if(isset($manifests [$option] ['additional_categories_needles'])) {
						$needles [$manifests [$option] ['additional_categories_needles']] = $needles ['category'];
					}
				}
			}
		}
		
		$needles ['categories'] = array (
				- 1 
		);
		$needles ['frontpage'] = array (
				- 1 
		);
		$needles ['home'] = array (
				- 1
		);
		$needles ['front'] = array (
				- 1
		);
		
		// If the component works using category_id = 0 as the fallback view treated as the home, add a fallback needles accordingly 
		if(isset($manifests [$option] ['category_zero_as_home'])) {
			array_push($needles['category'], 0);
		}
		
		// Find all parents category if supported
		if(isset($manifests [$option] ['fallback_views'])) {
			foreach ($manifests [$option] ['fallback_views'] as $fallBackView) {
				$needles [$fallBackView] = array (
						- 1
				);
			}
		}
		
		if ($foundItemid = self::findItem ( $option, $needles, $manifests [$option], $thisView )) {
			return $foundItemid;
		}
		
		return false;
	}
}
