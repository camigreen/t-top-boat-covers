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

<?php if ($category) : ?>
<?php $link = $this->app->route->category($category); ?>
<a href="<?php echo $link; ?>" title="<?php echo $category->name; ?>">
    <div class="product-container uk-text-center" data-uk-scrollspy="{cls:'uk-animation-fade', repeat:true, delay:<?php echo $fader; ?>}">
        <div class="uk-width-1-1 uk-vertical-align" style="height:200px;">
            <?php if (($logo_image = $category->getImage('content.logo_image')) && $this->params->get('template.show_categories_images')) : ?>
            <div class="uk-width-1-1 uk-vertical-align-middle">
                <img src="<?php echo $logo_image['src']; ?>" title="<?php echo $category->name; ?>" alt="<?php echo $category->name; ?>" <?php echo $logo_image['width_height']; ?>/>
            </div>
            <?php endif; ?>
        </div>
        <div class="uk-width-1-1 uk-vertical-align" style="height:150px;">
            <?php if (($teaser_image = $category->getImage('content.teaser_image')) && $this->params->get('template.show_categories_images')) : ?>
            <div class="uk-width-1-1 uk-vertical-align-middle uk-height-1-1">
                <img src="<?php echo $teaser_image['src']; ?>" title="<?php echo $category->name; ?>" alt="<?php echo $category->name; ?>" <?php echo $teaser_image['width_height']; ?>/>
            </div>
        <?php endif; ?>
        </div>
    </div>
</a>
<?php endif;