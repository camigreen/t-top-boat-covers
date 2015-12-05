<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
$class = $item->type.'-full';
$_item = $storeItem->item;
?>
<div id="<?php echo $_item['id'] ?>" class="uk-grid ttop <?php echo $item->type; ?>" data-item='<?php echo $storeItem->getJson(); ?>'>
    <div class="uk-width-1-1 top-container">
        <?php if ($this->checkPosition('top')) : ?>
        <?php echo $this->renderPosition('top', array('style' => 'block')); ?>
        <?php endif; ?>
    </div>
    <div class="uk-width-1-1 title-container uk-margin-top">
        <?php if ($this->checkPosition('title')) : ?>
        <h1><?php echo $this->renderPosition('title', array('style' => 'block')); ?></h1>
        <?php endif; ?>
    </div>
    
    <div class="uk-width-1-3">
        <div class="uk-width-1-1 media-container">
            <?php if ($this->checkPosition('media')) : ?>
                <?php echo $this->renderPosition('media', array('style' => 'block')); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="uk-width-1-3">
        <div class="uk-width-1-1 description-container">
            <?php if ($this->checkPosition('description')) : ?>
                <h3><?php echo JText::_('Description'); ?></h3>
                <?php echo $this->renderPosition('description', array('style' => 'block')); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="uk-width-1-3">
        <div class="uk-width-1-1 price-container">
            <?php if ($this->checkPosition('price')) : ?>
                <?php echo $this->renderPosition('price', array('style' => 'pricing')); ?>
            <?php endif; ?>
        </div>
        <div class="uk-width-1-1 options-container uk-margin-top">
            <?php if ($this->checkPosition('options')) : ?>
                <div class="uk-panel uk-panel-box">
                    <h3><?php echo JText::_('Options'); ?></h3>
                    <div class="validation-errors">

                    </div>
                        <?php echo $this->renderPosition('options', array('style' => 'options')); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="uk-width-1-1 addtocart-container uk-margin-top">
            <?php if ($this->checkPosition('addtocart')) : ?>
                <?php echo $this->renderPosition('addtocart', array('style' => 'block', 'item_id' => $_item['id'])); ?>
            <?php endif; ?>
        </div>
    </div>
    
    
    
</div>
<div class="modals">
    <?php if ($this->checkPosition('modals')) : ?> 
        <?php echo $this->renderPosition('modals'); ?>
    <?php endif; ?>
</div>


<script>
    jQuery(function($) {
        var mainItem = jQuery('#<?php echo $_item['id']; ?>');
        
        $(document).ready(function(){

            mainItem.StoreItem({
                name: 'Sandbags',
                validate: true,
                confirm: false,
                debug: false,
                events: {
                    onInit: [
                    ],
                    onChanged: [],
                    validate: [],
                    beforeAddToCart: []
                },
                removeValues: true,
                pricePoints: {}




            });
        });
        
    });
    
    
</script>