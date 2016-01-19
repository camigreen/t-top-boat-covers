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
<div class="uk-height-1-1">
<?php if ($this->checkPosition('title')) : ?>
    <a href="<?php echo $this->app->route->item($this->_item) ?>">
        <div class="uk-panel uk-panel-box uk-panel-box-primary uk-width-1-1 test">
            <div style="float:left;"><?php echo $this->renderPosition('title'); ?></div>
            <div style="float:right;"><span class="uk-icon-chevron-right"></span></div>                 
        </div>
    </a>
<?php endif; ?>
    
            

<?php if ($this->checkPosition('media')) : ?>
    <div class="uk-vertical-align">
        <div class="uk-vertical-align-middle">
    <?php echo $this->renderPosition('media'); ?>
        </div>
    </div>
<?php endif; ?>

<?php if ($this->checkPosition('description')) : ?>
	<?php echo $this->renderPosition('description'); ?>
<?php endif; ?>

<?php if ($this->checkPosition('specification')) : ?>
<ul class="uk-list">
	<?php echo $this->renderPosition('specification', array('style' => 'uikit_list')); ?>
</ul>
<?php endif; ?>

<?php if ($this->checkPosition('links')) : ?>
<ul class="uk-subnav uk-subnav-line">
	<?php echo $this->renderPosition('links', array('style' => 'uikit_subnav')); ?>
</ul>
<?php endif; ?>
</a>
</div>