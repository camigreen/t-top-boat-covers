<?php
/**
* @package   ZOO Item
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$media_position = $params->get('media_position', 'top');


?>
<div class="product <?php if ($media_position == 'top' || $media_position == 'middle' || $media_position == 'bottom') echo 'uk-text-center'; ?>">


        <?php if ($this->checkPosition('title')) : ?>
        <div class="uk-panel uk-panel-box uk-panel-box-primary">
            <div style="float:left;"><?php echo $this->renderPosition('title'); ?></div>
            <div style="float:right;"><span class="uk-icon-chevron-right"></span></div>
        </div>
        <?php endif; ?>

        <?php if ($this->checkPosition('media')) : ?>
    <div class="uk-vertical-align" style="height:300px;">
        <div class="uk-vertical-align-middle">
            <?php echo $this->renderPosition('media'); ?>
        </div>
    </div>
                
        <?php endif; ?> 
            
        <?php if ($this->checkPosition('buttons')) : ?>
            
                <div class="buttons uk-width-1-1">
                    <?php echo $this->renderPosition('buttons'); ?>
                </div>
                    

        <?php endif; ?> 

</div>