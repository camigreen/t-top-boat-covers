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

$catsave = null;
$close = '';
$showPageBreaks = $this->cparams->get ( 'show_pagebreaks', 1 );
$openTarget =  $this->sourceparams->get ( 'opentarget', $this->cparams->get ('opentarget') );

// Get default menu - home and check if a single article is linked, if so skip to avoid duplicated content
$homeArticleID = false;
$defaultMenu = $this->application->getMenu()->getDefault(JFactory::getLanguage()->getTag());
if(	isset($defaultMenu->query['option']) &&
	isset($defaultMenu->query['view']) &&
	$defaultMenu->query['option'] == 'com_content' &&
	$defaultMenu->query['view'] == 'article') {
	$homeArticleID = (int)$defaultMenu->query['id'];
}

if (count ( $this->source->data ) != 0) {
	require_once (JPATH_BASE . '/components/com_content/helpers/route.php');
	$first = true;
	
	foreach ( $this->source->data as $elm ) {
		// Article found as linked to home, skip and avoid duplicate link
		if((int)$elm->id === $homeArticleID) {
			continue;
		}
		
		// Set for empty category root nodes that should not be clickable
		$noExpandableNode = $elm->id ? '' : ' noexpandable';
		if ($elm->catid != $catsave && ! $first) {
			echo '</ul></li></ul>';
			echo '<ul class="jmap_filetree" style="margin-left:' . (15 * ($elm->level - 1)) . 'px"><li class="' . $noExpandableNode . '"><span class="folder">' . $elm->category . '</span>';
			echo '<ul>';
			$catsave = $elm->catid;
		} else {
			if ($first) {
				echo '<ul class="jmap_filetree" style="margin-left:' . (15 * ($elm->level - 1)) . 'px"><li class="' . $noExpandableNode . '"><span class="folder">' . $elm->category . '</span>';
				echo '<ul>';
				$first = false;
				$catsave = $elm->catid;
			}
		}
		
		if (@$elm->slug) {
			$seolink = $this->liveSite . JRoute::_ ( ContentHelperRoute::getArticleRoute ( $elm->slug, $elm->catslug, $elm->language ) );
		} else {
			$seolink = $this->liveSite . JRoute::_ ( $elm->link );
		}
		
		echo '<li>' . '<a target="' . $openTarget . '" href="' . $seolink . '" >' . $elm->title . '</a>';
		
		if(!empty($elm->expandible) && $showPageBreaks) {
			echo '<ul>';
			foreach ($elm->expandible as $index=>$subPageBreak) {
				if (@$elm->slug) {
					$seolink = $this->liveSite . JRoute::_ ( ContentHelperRoute::getArticleRoute ( $elm->slug, $elm->catslug, $elm->language ) . '&limitstart=' . ($index + 1));
				} else {
					$seolink = $this->liveSite . JRoute::_ ( $elm->link . '&limitstart=' . ($index + 1));
				}
				echo '<li>' . '<a target="' . $openTarget . '" href="' . $seolink . '" >' . $subPageBreak . '</a></li>';
			}
			echo '</ul>';
		}
		echo '</li>';
	}
	
	echo '</ul></li></ul>';
}