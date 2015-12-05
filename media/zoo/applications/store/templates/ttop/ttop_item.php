<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

//$this->app->document->addStylesheet($this->template->resource.'assets/css/uikit.css');

$class = $this->template->name;

$item = $this->app->store->create($this->item);
$item->getJson();
$prices = $item->getPrices();
?>

<div class="yoo-zoo <?php echo $this->application->getGroup(); ?> <?php echo $class; ?>">
<?php if ($this->item->canEdit()) : ?>
    <?php $edit_link = $this->app->route->submission($this->item->getApplication()->getItemEditSubmission(), $this->item->type, null, $this->item->id, 'itemedit'); ?>
    <div class="uk-align-right">
        <a href="<?php echo JRoute::_($edit_link); ?>" title="<?php echo JText::_('Edit Item'); ?>" class="item-icon edit-item"><?php echo JText::_('Edit Item'); ?></a>
    </div>
<?php endif; ?>
	<?php echo $this->renderer->render('item.'.$this->item->type.'.full', array('view' => $this, 'item' => $this->item, 'storeItem' => $item, 'prices' => $prices)); ?>

	<?php if ($this->application->isCommentsEnabled() && ($this->item->isCommentsEnabled() || $this->item->getCommentsCount(1))) : ?>
		<?php echo $this->app->comment->renderComments($this, $this->item); ?>
	<?php endif; ?>
</div>