<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$link = $this->app->route->item($item);
$class = 'accessories related '.$item->type.'-related';
?>
<div class="<?php echo $class; ?>">
    <li class="uk-width-1-1">
        <div class="uk-grid">
            <?php if ($this->checkPosition('media')) : ?>
            <div class="uk-width-1-3">
                <a href="#<?php echo $item->alias.'-modal'; ?>" data-uk-modal>
                    <?php echo $this->renderPosition('media'); ?>
                </a>
            </div>
            <?php endif; ?>
            <div class="uk-width-2-3">
                <?php if ($this->checkPosition('title')) : ?>
                <a href="#<?php echo $item->alias.'-modal'; ?>" data-uk-modal>
                    <span class="uk-text-large title">
                        <?php echo $this->renderPosition('title'); ?>
                    </span>
                </a>
                <?php endif; ?>

                <?php if ($this->checkPosition('description')) : ?>
                    <span class="uk-text-small description">
                        <?php echo $this->renderPosition('description', array('style' => 'full_row')); ?>
                    </span>
                <?php endif; ?>

                <?php if ($this->checkPosition('specification')) : ?>
                        <?php echo $this->renderPosition('specification', array('style' => 'full_row')); ?>
                <?php endif; ?>
                <div class="button">
                    <a href="#<?php echo $item->alias.'-modal'; ?>" data-uk-modal="{center:true}">Add To Cart</a>
                    <a href="<?php echo $link; ?>" target="_blank">More Info</a>
                </div>
                <?php if ($this->checkPosition('links')) : ?>
                <ul class="uk-subnav uk-subnav-line">
                        <?php echo $this->renderPosition('links', array('style' => 'uikit_subnav')); ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
        <div id="<?php echo $item->alias.'-modal'; ?>" class="uk-modal">
                <?php echo $modal ?>
        </div>
    </li>
</div> 