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
defined ( '_JEXEC' ) or die ( 'Restricted access' );

$sourceTitle = $this->sourceparams->get ( 'title', $this->source->name );
$showtitle = $this->sourceparams->get ( 'showtitle', 1 );
$openTarget = $this->sourceparams->get ( 'opentarget', $this->cparams->get ('opentarget') );

if (! $showtitle) {
	$sourceTitle = '&nbsp;';
}

// Include common template init
include 'default_common_user.php';

if (count ( $this->source->data )) {
	// If categorization detected for datasource elements according to adiacency/multi adiacency setup, Feature Detection
	if(isset($this->source->catRecursion) && isset($this->source->itemsByCat) && isset($this->source->catChildrenByCat)) {
		echo '<ul class="jmap_filetree"><li><span class="folder">' . $sourceTitle. '</span>';
		// Start building tree
		recurseCats(0, 
					$this->source->itemsByCat, 
					$this->source->catChildrenByCat, 
					0, 
					$this->asCategoryTitleField, 
					$this->liveSite, 
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
		echo '</ul></li></ul></li></ul>';
	}
	// If categorization detected for datasource elements group by categories
	elseif(isset($this->source->data[0]->{$this->asCategoryTitleField}) || isset($this->source->data[0]->jsitemap_level)){
		$first = true;
		$catsave = null;
		$catRecursion = false;
		$liIndent = null;
		$hasValidCategoryTitleField = (bool)(isset($this->asCategoryTitleField) && $this->asCategoryTitleField);
		// Manage levels, Feature Detection
		if(isset($this->source->catRecursion) && isset($this->source->data[0]->jsitemap_level) && $this->source->recursionType == 'level') {
			$catRecursion = true;
		}
		echo '<ul class="jmap_filetree"><li><span class="folder">' . $sourceTitle. '</span>';
		foreach ( $this->source->data as $elm ) {
			// Calculate element indentation, Feature Detection
			$indent = $catRecursion ? ($elm->jsitemap_level - 1) * 15 : 0;
			
			if($hasValidCategoryTitleField) {
				if ($elm->{$this->asCategoryTitleField} != $catsave && ! $first) {
					echo '</ul></li></ul>';
					echo '<ul class="jmap_filetree" style="margin-left:' . $indent . 'px"><li><span class="folder">' . $elm->{$this->asCategoryTitleField} . '</span>';
					echo '<ul>';
					$catsave = $elm->{$this->asCategoryTitleField};
				} else {
					if ($first) {
						echo '<ul class="jmap_filetree" style="margin-left:' . $indent . 'px"><li><span class="folder">' . $elm->{$this->asCategoryTitleField} . '</span>';
						echo '<ul>';
						$first = false;
						$catsave = $elm->{$this->asCategoryTitleField};
					}
				}
			}
				
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
			
			if(!$hasValidCategoryTitleField && $catRecursion) {
				$liIndent = ' style="margin-left:' . ($indent + 15) . 'px"';
			}
			
			echo '<li' . $liIndent .'>' . '<a target="' . $openTarget . '" href="' .  $this->liveSite . $seflink . '" >' . $title . '</a></li>';
		}
		if($hasValidCategoryTitleField) {
			echo '</ul></li></ul>';
		}
		echo '</li></ul>';
	} else { // No categorization detected for datasource elements
		echo '<ul class="jmap_filetree"><li><span class="folder">' . $sourceTitle. '</span><ul>';
		foreach ( $this->source->data as $elm ) {
			$title = isset($titleIdentifier) &&  $titleIdentifier != ''  ? $elm->{$titleIdentifier} : null;
			// Additional fields
			$additionalQueryStringFromObjectProp = null;
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
			echo '<li>' . '<a target="' . $openTarget . '" href="' . $this->liveSite . $seflink . '" >' . $title . '</a></li>';
		}
		echo '</ul></li></ul>';
	}
}