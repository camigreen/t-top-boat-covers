<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
$elem_id = $this->_item->alias.'-modal';
?>



<div id="<?php echo $elem_id; ?>" class="uk-modal">
    <div class="uk-modal-dialog <?php echo ($params['modal_large'] ? 'uk-modal-dialog-large' : ''); ?>">
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-1-1">
                <?php if ($this->checkPosition('description')) : ?>
                    <?php echo $this->renderPosition('description'); ?>
                <?php endif; ?>
            </div>          
        </div>
        
    </div>
    <?php if ($this->checkPosition('scripts')) : ?>
        <?php echo $this->renderPosition('scripts'); ?>          
    <?php endif; ?>
</div>
