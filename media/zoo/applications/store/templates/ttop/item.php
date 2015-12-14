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

$class = $this->template->name.'';


echo $this->item->type;
?>

<div class="yoo-zoo <?php echo $this->application->getGroup(); ?> <?php echo $class; ?> ttop-item">
    <?php echo $this->renderer->render('item.'.$this->item->type.'.full', array('view' => $this, 'item' => $this->item)); ?>

    <?php if ($this->application->isCommentsEnabled() && ($this->item->isCommentsEnabled() || $this->item->getCommentsCount(1))) : ?>
            <?php echo $this->app->comment->renderComments($this, $this->item); ?>
    <?php endif; ?>
</div>