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

$priority =  $this->sourceparams->get ( 'priority', '0.5' );
$changefreq = $this->sourceparams->get ( 'changefreq', 'daily' );
$imagetitleProcessorRegexp = $this->sourceparams->get('imagetitle_processor', $this->cparams->get('imagetitle_processor', 'title|alt'));

// Init exclusion
$imgFilterInclude = array();
if(trim($this->sourceparams->get ( 'images_filter_include', '' ))) {
	$imgFilterInclude = explode(',', $this->sourceparams->get ( 'images_filter_include', '' ));
}

$imgFilterExclude = array();
if(trim($this->sourceparams->get ( 'images_filter_exclude', 'pdf,print,email,media,templates' ))) {
	$imgFilterExclude = explode(',', $this->sourceparams->get ( 'images_filter_exclude', 'pdf,print,email,media,templates' ));
}

// Include common template init
include 'default_common_user.php';

if (count ( $this->source->data ) != 0) {  
	foreach ( $this->source->data as $elm ) {
		// Check to ensure is counting valid request
		if(!$this->HTTPClient->isValidRequest()) {
			break;
		}
		
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
		
		// Skip outputting
		if(array_key_exists($seflink, $this->outputtedLinksBuffer)) {
			continue;
		}
		// Else store to prevent duplication
		$this->outputtedLinksBuffer[$seflink] = true;
		
		// HTTP Request to remote URL '$seolink' to get images
		$headers = array('Accept'=>'text/html');
		$HTTPResponse = $this->HTTPClient->get($this->liveSite . $seflink, $headers);
		$pageHtml = $HTTPResponse->body;
		// Images RegExp extraction
		$imagesArrayResults = array();
		preg_match_all ( '/(<img)([^>])*(src=["\']([^"\']+)["\'])([^>])*/i', $pageHtml, $imagesArrayResults );
		$imagesTags = $imagesArrayResults[0];
		$imagesLinks = $imagesArrayResults[4];
		
$bufferImages = null;
if(!empty($imagesLinks)):
ob_start();
foreach ($imagesLinks as $index=>$imageLink):
$validImage = true;
$found = false;
$optionalImageTitle = false;
// Extended images filtering include
if(is_array($imgFilterInclude) && count($imgFilterInclude)):
	foreach ($imgFilterInclude as $filterInclude) :
		if(strstr($imagesTags[$index], trim($filterInclude))) {
			$found = true;
			break;
		}
	endforeach;
if(!$found):
$validImage = false;
endif;
endif;

// Extended images filtering exclude
if(is_array($imgFilterExclude) && count($imgFilterExclude)):
	foreach ($imgFilterExclude as $filterExclude) :
		if(strstr($imagesTags[$index], trim($filterExclude))) {
			$validImage = false;
			break;
		}
	endforeach;
endif;
// Image not valid so don't insert in sitemap
if(!$validImage)
	continue;
// Check for optional image title
if(stristr($imagesTags[$index], 'title=') || stristr($imagesTags[$index], 'alt=')) {
	$optionalTitleMatches = array();
	preg_match('/(<img)([^>])*(('.$imagetitleProcessorRegexp.')=(["\'])([^\5]*)\5)/iU', $imagesTags[$index], $optionalTitleMatches);
	if(!empty($optionalTitleMatches[6])) {
		$optionalImageTitle = '<image:title>' . htmlspecialchars($optionalTitleMatches[6], null, 'UTF-8', false) . '</image:title>' . PHP_EOL;
	}
}
?>
<image:image>
<image:loc><?php echo htmlspecialchars(preg_match('/http/i', $imageLink) ? $imageLink : $this->liveSite . '/' . ltrim($imageLink, '/'), null, 'UTF-8', false);?></image:loc>
<?php echo $optionalImageTitle;?>
</image:image>
<?php 
endforeach;
$bufferImages = ob_get_clean();
endif;

// Se sono presenti immagini
if(isset($bufferImages) && !empty($bufferImages)):
?>
<url>
<loc><?php echo $this->liveSite . $seflink; ?></loc>
<?php echo $bufferImages; ?>
</url>
<?php 
endif;
	}
}