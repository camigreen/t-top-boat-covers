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

$classdiv = $this->cparams->get ( 'classdiv', '' );
$columnSitemap = $this->cparams->get('column_sitemap', 0);
// Evaluate if tmpl is used for example for component from a custom HTML module IFrame
$isTmpl = $this->app->input->get('tmpl', false);
echo $classdiv ? '<div id="jmap_sitemap" class="' . $classdiv . '">' : '<div>';
if($columnSitemap && !$isTmpl) {
	$this->document->addStyleDeclaration('div.jmapcolumn{float:left;width: 33%;}#jmap_sitemap{overflow:hidden;}');
	$this->document->addStyleDeclaration('@media (max-width:639px) {div.jmapcolumn {width:100%;float: none;}}');
}

// title
$cshowtitle = $this->cparams->get ( 'show_title', 1 );
$headerlevel = $this->cparams->get ( 'headerlevel', $this->cparams->get ( 'headerlevel', 1 ) );

if ($cshowtitle) {
	$title = $this->cparams->get ( 'maintitle', $this->cparams->get ( 'defaulttitle', null ) );
	if(!$title) {
		$title = $this->menuname;
	}
	echo '<h' . $headerlevel . '>' . $title . '</h' . $headerlevel . '>';
} 

$section_headerlevel = $categorie_headerlevel = $headerlevel + 2;
$title_headerlevel = $headerlevel + 3;

// Init multicolumns
$numColumn = 3;
$maxPerColumn = 1;
// Find informations for multicolumn data sources
$numDataSources = count($this->data);
$alwaysNewColumn = (bool)($numDataSources <= $numColumn);
if(!$alwaysNewColumn) {
	// Rest data sources for last 3rd column
	$rest = $numDataSources % $numColumn;
	// Integer part for 2 main column
	$integralNum = $numDataSources - $rest;
	// Max Data Sources assigned to single column, following %3 eg. n-2/n-1/n, 6|6|4, 6|6|5, 6|6|6, 7|7|5, 7|7|6, 7|7|7, etc 
	$maxPerColumn = ($integralNum / $numColumn) + ($rest ? 1 : 0);
}

// Init foreach cycle on data sources
$datasourceCounter = 0;
$currentColumn = 1;
foreach ( $this->data as $source ) {
	if($datasourceCounter === 0) {
		echo '<div class="jmapcolumn instance' . $currentColumn . '">';
		$currentColumn = 1;
	} elseif ($datasourceCounter % $maxPerColumn == 0 || $alwaysNewColumn) {
		$currentColumn++;
		echo '</div>';
		echo '<div class="jmapcolumn instance' . $currentColumn . '">';
	}
	// Store source type to track changes
	$currentSourceType = $source->type;
	// Strategy pattern source type template visualization
	if ($source->type) {
		$this->source = $source;
		$this->sourceparams = $source->params;
		$this->asCategoryTitleField = $this->findAsCategoryTitleField($source);
		if($this->sourceparams->get('htmlinclude', 1)) {
			$subTemplateName = $this->_layout . '_html_' . $source->type . '.php';
			if (file_exists ( JPATH_COMPONENT . '/views/sitemap/tmpl/' . $subTemplateName )) {
				echo $this->loadTemplate ( 'html_' . $source->type );
			}
		}
	}
	$datasourceCounter++;
}
echo '</div></div>';