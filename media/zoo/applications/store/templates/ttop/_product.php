<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
if ($category->itemCount() == 1) {
    foreach($category->getItems() as $item) {
        $link = $this->app->route->item($item);
    }  
} else {
    $link = $this->app->route->category($category);
}
?>

<?php if ($category) : ?>
        <div class="uk-panel uk-panel-box uk-panel-box-primary">
                <div style="float:left;">
                    <?php echo $category->name; ?>
                </div>
                <div style="float:right;">
                    <span class="uk-icon-chevron-right"></span>
                </div>
        </div>     

	<?php if ($this->params->get('template.show_categories_descriptions') && $category->getParams()->get('content.teaser_description')) : ?>
	<?php echo $category->getParams()->get('content.teaser_description'); ?>
	<?php endif; ?>
	<?php if (($image = $category->getImage('content.teaser_image')) && $this->params->get('template.show_categories_images')) : ?>
	<div class="uk-vertical-align" style="height:300px;">
            <div class="uk-vertical-align-middle">
                <img src="<?php echo $image['src']; ?>" title="<?php echo $category->name; ?>" alt="<?php echo $category->name; ?>" <?php echo $image['width_height']; ?>/>
            </div>
	</div>
	<?php endif; ?>

                <div class="buttons uk-width-1-1">
                    <?php if ($category->params->get('content.more_info_button') && $category->params->get('content.more_info_url')) : ?>
                        <a href="<?php echo $category->params->get('content.more_info_url'); ?>" class="uk-button uk-button-danger">More Info</a>
                    <?php endif; ?>
                    <?php if ($category->params->get('content.order_now_button')) : ?>
                        <a href="<?php echo $category->params->get('content.order_now_url') ? $category->params->get('content.order_now_url') : $link; ?>" class="uk-button uk-button-danger">Order Now</a>
                    <?php endif; ?>
                </div>

<?php endif;