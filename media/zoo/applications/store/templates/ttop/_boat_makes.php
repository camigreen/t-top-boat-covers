<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<?php if ($categoriestitle) : ?>
<h2><?php echo $categoriestitle; ?></h2>
<?php endif; ?>
<div class="uk-margin">
<?php

	// init vars
	$i = 0;
	$columns = $this->params->get('template.categories_cols', 2);
	reset($this->selected_categories);

	// render rows
	while ((list($key, $category) = each($this->selected_categories))) {
		if ($category && !($category->totalItemCount() || $this->params->get('config.show_empty_categories', false)) || !$category->params->get('content.show_category_page', true)) continue;
                $fader = ($i % $columns)*300;
		if ($i % $columns == 0) echo ($i > 0 ? '</div><hr class="uk-grid-divider"><div class="uk-grid" data-uk-grid-margin data-uk-grid-match>' : '<div class="uk-grid" data-uk-grid-margin data-uk-grid-match>');
                echo '<div class="uk-width-medium-1-'.$columns.' product">'.$this->partial('boat_make', compact('category', 'fader')).'</div>';
                
		$i++;
	}
	if (!empty($this->selected_categories)) {
	}

?>
</div>