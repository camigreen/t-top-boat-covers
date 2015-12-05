<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$this->app->document->addStylesheet($this->template->resource.'assets/css/uikit.css');
$this->app->document->addScript($this->template->resource.'assets/js/uikit.js');

// show description only if it has content
if (!$this->application->description) {
	$this->params->set('template.show_description', 0);
}

// show title only if it has content
if (!$this->application->getParams()->get('content.title')) {
	$this->params->set('template.show_title', 0);
}

// show image only if an image is selected
if (!($image = $this->application->getImage('content.image'))) {
	$this->params->set('template.show_image', 0);
}

$css_class = $this->template->name;
?>

<div class="yoo-zoo <?php echo $css_class; ?> <?php echo $css_class.'-frontpage'; ?> <?php echo 'uk-text-'.$this->params->get('template.alignment'); ?>">

	<?php if ($this->params->get('template.show_title') || $this->params->get('template.show_description') || $this->params->get('template.show_image')) : ?>

		<?php if ($this->params->get('template.show_title')) : ?>
		<span class="frontpage-title-product <?php echo 'uk-text-'.$this->params->get('template.alignment'); ?> uk-article-title"><?php echo $this->application->getParams()->get('content.title'); ?></span>
		<?php endif; ?>
                
		<?php if ($this->params->get('template.show_description') || $this->params->get('template.show_image')) : ?>
		<div class="uk-margin">
			<?php if ($this->params->get('template.show_image')) : ?>
			<img class="<?php echo 'uk-align-'.($this->params->get('template.alignment') == "left" || $this->params->get('template.alignment') == "right" ? 'medium-' : '').$this->params->get('template.alignment'); ?>" src="<?php echo $image['src']; ?>" title="<?php echo $this->application->getParams()->get('content.title'); ?>" alt="<?php echo $this->application->getParams()->get('content.title'); ?>" <?php echo $image['width_height']; ?>/>
			<?php endif; ?>
			<?php if ($this->params->get('template.show_description')) echo $this->application->getText($this->application->description); ?>
		</div>
		<?php endif; ?>

	<?php endif; ?>
                
                
	<?php
		// render categories

		if ($this->params->get('template.show_categories', true) && ($this->category->childrenHaveItems() || ($this->params->get('config.show_empty_categories', false) && !empty($this->selected_categories)))) {
			$categoriestitle = $this->application->getText($this->application->getParams()->get('content.categories_title'));
			echo $this->partial('products', compact('categoriestitle'));
		}

	?>

</div>
<div class="uk-text-center">
                        <div class="uk-thumbnail"><img src="images/flag.gif" alt="flag" width="134" height="85" />
                                <div class="uk-thumbnail-caption"><span class="uk-text-large uk-text-bold">Proudly</span><br /><span class="uk-text-large">Made in the USA!</span>
                                </div>
                        </div>
                </div>