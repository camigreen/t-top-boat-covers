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
$data_item = array('id' => $item->id, 'name' => $item->name);
$storeItem = $this->app->item->create($item, $item->alias);
//var_dump($storeItem->options);

?>
<div id="storeOrderForm" class="<?php echo $item->type; ?>">
    <div id="<?php echo $item->id; ?>" class="uk-form uk-grid ttop storeItem" data-item='<?php echo $storeItem->getItemsJSON(); ?>'>
        <div class="uk-width-1-1 top-container">
            <?php if ($this->checkPosition('top')) : ?>
            <?php echo $this->renderPosition('top', array('style' => 'block')); ?>
            <?php endif; ?>
        </div>
        <div class="uk-width-1-1 title title-container uk-margin-top">
            <?php if ($this->checkPosition('title')) : ?>
            <p class="uk-article-title"><?php echo $this->renderPosition('title'); ?></p>
            <?php endif; ?>
        </div>
        
        <div class="uk-width-1-3 uk-margin-top">
            <div class="uk-width-1-1 media-container">
                <?php if ($this->checkPosition('media')) : ?>
                    <?php echo $this->renderPosition('media', array('style' => 'blank')); ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="uk-width-1-3 uk-margin-top">
            <div class="uk-width-1-1 description-container">
                <?php if ($this->checkPosition('description')) : ?>
                    <h3><?php echo JText::_('Description'); ?></h3>
                    <?php echo $this->renderPosition('description', array('style' => 'blank')); ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="uk-width-1-3 uk-margin-top">
            <div class="uk-width-1-1 uk-grid price-container">
                        <?php if ($this->checkPosition('pricing')) : ?>
                                <?php echo $this->renderPosition('pricing', array('item' => $storeItem)); ?>
                        <?php endif; ?>
                    </div>
            <div class="uk-width-1-1 options-container uk-margin-top" data-id="<?php echo $storeItem->id; ?>">
                <?php if ($this->checkPosition('options')) : ?>
                    <div class="uk-panel uk-panel-box">
                        <h3><?php echo JText::_('Options'); ?></h3>
                        <div class="validation-errors"></div>
                        <?php echo $this->renderPosition('options', array('style' => 'user_options')); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="uk-width-1-1 addtocart-container uk-margin-top">
                <label>Quantity</label>
                <input id="qty-<?php echo $item->id; ?>" type="number" class="uk-width-1-1 qty" data-id="<?php echo $storeItem->id; ?>" name="qty" min="1" value ="1" />
                <div class="uk-margin-top">
                    <button id="atc-<?php echo $item->id; ?>" class="uk-button uk-button-danger atc" data-id="<?php echo $storeItem->id; ?>"><i class="uk-icon-shopping-cart" data-store-cart style="margin-right:5px;"></i>Add to Cart</button>
                </div>
            </div>
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
        var subItem = jQuery('#storeOrderForm');
        
        $(document).ready(function(){

            subItem.StoreItem({
                name: 'Accessories',
                validate: true,
                confirm: false,
                debug: true,
                events: {}
            });
        });
        
    });
    
    
</script>

