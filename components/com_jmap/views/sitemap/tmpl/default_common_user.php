<?php
/** 
 * @package JMAP::SITEMAP::components::com_jmap
 * @subpackage views
 * @subpackage sitemap
 * @subpackage tmpl
 * @author Joomla! Extensions Store
 * @copyright (C) 2014 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined('_JEXEC') or die('Restricted access');

// Additional query string params
$additionalQueryStringParams =  $this->sourceparams->get ( 'additionalquerystring', null);
$sefItemid = $this->sourceparams->get ( 'sef_itemid', null);
$guessItemid = $this->sourceparams->get ( 'guess_sef_itemid', 0);

if($sefItemid > 0 && !$guessItemid) {
	$additionalQueryStringParams .= ',Itemid=' . $sefItemid;
}
$additionalQueryStringParams = trim($additionalQueryStringParams, ',');
if($additionalQueryStringParams) {
	$additionalQueryStringParams = '&' . preg_replace('/,\s*/i', '&', $additionalQueryStringParams);
	$additionalQueryStringParams =  preg_replace('/\s+/i', '', $additionalQueryStringParams);
}

$targetOption = $this->source->chunks->option;
$targetViewName = $this->sourceparams->get ( 'view', null );
$targetView = $targetViewName ? '&view=' . $targetViewName : null;

// Supported adapters for Router Helper
$supportedRouterHelperAdapters = array(	'com_k2'=>false,
										'com_contact'=>false,
										'com_weblinks'=>false,
										'com_newsfeeds'=>false,
										'com_hwdmediashare'=>false,
										'com_eventbooking'=>false,
										'com_edocman'=>false,
										'com_phocadownload'=>false,
										'com_ezrealty'=>false,
										'com_iproperty'=>false,
										'com_djcatalog2'=>false,
										'com_jomestate'=>false);
$supportedRouterHelperAdaptersPaths = array('com_eventbooking'=>'helper',	
											'com_edocman'=>'helper');
$supportedRouterHelperAdaptersFiles = array();
if(array_key_exists($targetOption, $supportedRouterHelperAdapters)) {
	$folderPath = array_key_exists($targetOption, $supportedRouterHelperAdaptersPaths) ? $supportedRouterHelperAdaptersPaths[$targetOption] : 'helpers';
	$filePath = array_key_exists($targetOption, $supportedRouterHelperAdaptersFiles) ? $supportedRouterHelperAdaptersFiles[$targetOption] : 'route';
	if(file_exists(JPATH_SITE . '/components/'.$targetOption.'/'.$folderPath.'/'.$filePath.'.php')) {
		include_once JPATH_SITE . '/components/'.$targetOption.'/'.$folderPath.'/'.$filePath.'.php';
		$supportedRouterHelperAdapters[$targetOption] = true;
		$liveSite = $this->liveSite;
	}
}

// Fallback identifiers
$titleIdentifier =  !empty($this->source->chunks->titlefield_as) ?  $this->source->chunks->titlefield_as :  $this->source->chunks->titlefield;
$idIdentifier = !empty($this->source->chunks->idfield_as) ?  $this->source->chunks->idfield_as :  $this->source->chunks->id;
$catidIdentifier = !empty($this->source->chunks->catidfield_as) ?  $this->source->chunks->catidfield_as : !empty($this->source->chunks->catid) ? $this->source->chunks->catid : null;
$idURLFilter = !empty($this->source->chunks->url_filter_id) ? true : false;
$catidURLFilter = !empty($this->source->chunks->url_filter_catid) ? true : false;
$mainTable = $this->source->chunks->table_maintable;

// Init array key diff fields standard
$arrayKeysDiff = array(	$titleIdentifier=>null,
		$this->asCategoryTitleField=>null,
		'jsitemap_level'=>null,
		'jsitemap_category_id'=>null,
		'metakey'=>null,
		'publish_up'=>null,
		'modified'=>null);

// Used for HTML user format sitemap, it gives feature for multilevel nested tree
if(!function_exists('recurseCats')) {
	function recurseCats($id, 
						$itemsByCats, 
						$catChildrenByCats, 
						$level = 0, 
						$asCategoryTitleField, 
						$liveSite, 
						$targetOption, 
						$targetView, 
						$targetViewName,
						$additionalQueryStringParams, 
						$openTarget, 
						$arrayKeysDiff, 
						$titleIdentifier, 
						$idIdentifier, 
						$idURLFilter, 
						$catidIdentifier, 
						$catidURLFilter,
						$supportedRouterHelperAdapters,
						$guessItemid,
						$mainTable) {
		if(isset($catChildrenByCats[$id])) {
			foreach ( $catChildrenByCats[$id] as $catChild ) {
				$itemsOfCategory = isset ($itemsByCats[$catChild['id']]) ? ($itemsByCats[$catChild['id']]) : null;
				$catTitleName = $catChild['catname'] ;
				
				// Multilevel tree for items and parent containing cats
				if($asCategoryTitleField) {
					// Set for empty category root nodes that should not be clickable
					$noExpandableNode = count($itemsOfCategory) ? '' : ' noexpandable';
					echo '<ul class="jmap_filetree" style="margin-left:' . $level * 15 .'px"><li class="' . $noExpandableNode . '"><span class="folder">' . $catTitleName . '</span>';
					echo '<ul>';
				} else {
					// Multilevel tree of categories itself
					echo '<ul style="margin-left:' . $level * 15 .'px">';
				}
				
				if(count($itemsOfCategory)) {
					foreach ($itemsOfCategory as $elm) {
						$title = isset($titleIdentifier) &&  $titleIdentifier != '' ? $elm->{$titleIdentifier} : null;
						// Additional fields
						$additionalParamsQueryString = null;
						$objectVars = array_diff_key(get_object_vars($elm), $arrayKeysDiff);
						// Filter URL safe alias fields id/catid
						if(isset($objectVars[$idIdentifier]) && $idURLFilter) {
							$objectVars[$idIdentifier] = JFilterOutput::stringURLSafe($objectVars[$idIdentifier]);
						}
						if(isset($objectVars[$catidIdentifier]) && $catidURLFilter) {
							$objectVars[$catidIdentifier] = JFilterOutput::stringURLSafe($objectVars[$catidIdentifier]);
						}
						if(is_array($objectVars) && count($objectVars)) {
							$additionalQueryStringFromObjectProp = '&' . http_build_query($objectVars);
						}

						if(isset($supportedRouterHelperAdapters[$targetOption]) && $supportedRouterHelperAdapters[$targetOption]) {
							include 'adapters/'.$targetOption.'.php';
						} else {
							$guessedItemid = null;
							if($guessItemid) {
								$guessedItemid = JMapRouteHelper::getItemRoute($targetOption, $targetViewName, $elm->{$idIdentifier}, $elm, $mainTable);
								if($guessedItemid) {
									$guessedItemid = '&Itemid=' . $guessedItemid;
								}
							}
							$seflink = JRoute::_ ( 'index.php?option=' . $targetOption . $targetView . $additionalQueryStringFromObjectProp . $additionalQueryStringParams . $guessedItemid);
						}
						
						echo '<li>' . '<a target="' . $openTarget . '" href="' .  $liveSite . $seflink . '" >' . $title . '</a></li>';
					}
				}
				if($asCategoryTitleField) {
					echo '</ul>';
				}
				echo '</li></ul>';
				recurseCats($catChild['id'], 
							$itemsByCats, 
							$catChildrenByCats, 
							$level+1, 
							$asCategoryTitleField, 
							$liveSite, 
							$targetOption, 
							$targetView,
							$targetViewName,
							$additionalQueryStringParams, 
							$openTarget, 
							$arrayKeysDiff, 
							$titleIdentifier, 
							$idIdentifier, 
							$idURLFilter, 
							$catidIdentifier, 
							$catidURLFilter,
							$supportedRouterHelperAdapters,
							$guessItemid,
							$mainTable);
			}
		}
	}
}