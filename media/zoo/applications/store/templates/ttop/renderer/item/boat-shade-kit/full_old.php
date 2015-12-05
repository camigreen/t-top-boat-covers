<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
$product = $item->getPrimaryCategory();

?>
<div class="uk-form">
    <div class="uk-grid">
    <h1 class="uk-article-title uk-width-1-1"><?php echo $item->name; ?></h1>  
<!--<div class="uk-alert uk-alert-success uk-width-1-1">
    <p><span class="uk-icon-hand-o-down uk-text-large uk-margin-right"></span>
    Refer to the diagram below.  Enter the measurements to determine which Boat Shade Kit will fit your boat.</p>
</div>    -->
<?php if ($this->checkPosition('title')) : ?>
<div class="uk-width-1-1 uk-margin-top">
    <?php echo $this->renderPosition('title', array('style' => 'uikit_list')); ?>
</div>
<?php endif; ?>
    
<?php if ($this->checkPosition('media') && $view->params->get('template.item_media_alignment') == "left") : ?>
<div class="uk-width-2-3 uk-margin">
    <div class="uk-container">
        <?php echo $this->renderPosition('media', array('style' => 'block')); ?>
    </div>
</div>
<?php endif; ?>
    
<?php if ($this->checkPosition('pricing')) : ?>
<div class="uk-width-1-3 uk-margin-top">
    <fieldset>
        <div>
            <?php echo $this->renderPosition('pricing', array('style' => 'pricing')); ?>
        </div>
    </fieldset>
</div>
<?php endif; ?>
    
    
  
<div class="uk-width-1-1">
    <ul class="uk-tab" data-uk-tab="{connect:'#tabs'}">
        <?php if($product->description) : ?>
        <li>
            <a href="#">Description</a>
        </li>
        <?php endif; ?>
        <?php if ($this->checkPosition('tabs')) : ?>
            <?php echo $this->renderPosition('tabs', array('style' => 'tab')); ?>
        <?php endif; ?>
    </ul>
</div>
   
<ul id="tabs" style="min-height:150px;" class="uk-width-1-1 uk-switcher uk-margin">
    <?php if($product->description) : ?> 
    <li>
        <article class="uk-article">
            <?php echo $product->getText($product->description); ?>
        </article>
    </li>
    <?php endif; ?>
    <?php if ($this->checkPosition('tabs')) : ?>
        <?php echo $this->renderPosition('tabs', array('style' => 'tab_content')); ?>
    <?php endif; ?>
</ul>
    
<?php if ($this->checkPosition('measurements')) : ?>
<div class="uk-width-1-1 uk-margin-top">
    <fieldset> 
        <legend>
            <?php echo JText::_('Measurements'); ?>
        </legend>
        <div class="uk-grid">
            <?php echo $this->renderPosition('measurements', array('style' => 'options')); ?>
        </div>
    </fieldset>
</div>
<?php endif; ?>

<?php if ($this->checkPosition('diagram')) : ?>
<div class="uk-width-1-1 uk-margin-top">
    <fieldset> 
        <legend>
            <?php echo JText::_('Measurement Diagram'); ?>
        </legend>
        <div class="uk-grid">
            <?php echo $this->renderPosition('diagram', array('style' => 'block')); ?>
        </div>
    </fieldset>
</div>
<?php endif; ?>
 
<?php if ($this->checkPosition('media') && $view->params->get('template.item_media_alignment') == "right") : ?>
<div class="uk-width-1-2 uk-margin">
	<?php echo $this->renderPosition('media', array('style' => 'block')); ?>
</div>
<?php endif; ?>
    
<?php if ($this->checkPosition('bottom')) : ?>
	<?php echo $this->renderPosition('bottom', array('style' => 'block')); ?>
<?php endif; ?>
    </div>
    <div id="item-details">    
        <input type="hidden" name="name" value="<?php echo $name; ?>" />
        <input type="hidden" name="type" value="<?php echo $product->name; ?>" />
    </div>
    
    
</div>